<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImages;
use App\Models\ServiceReview;
use App\Models\Service;
use App\Models\SiteSetup;
use App\Models\User;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // index
    public function index(Request $request)
    {
        $search = $request->input('search');

        // Fetch the default currency from SiteSetup
        $defaultCurrency = SiteSetup::first()->default_currency;

        $records = Product::with(['category',  'productImages', 'vendor' => function ($query) {
            $query->select('id', 'firstname', 'lastname', 'email', 'profile_pic');
        }])
            ->when($search, function ($query, $search) {
                $query->where('product_name', 'like', "%{$search}%");
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Fetch average review ratings for each provider
        $providerIds = $records->pluck('vendor.id')->filter(); // Get unique provider IDs
        $avgProviderReviews = ServiceReview::whereIn('provider_id', $providerIds)
        ->selectRaw('provider_id, COALESCE(AVG(star_count), 0) as avg_star')
        ->groupBy('provider_id')
        ->pluck('avg_star', 'provider_id'); // Fetch avg star rating per provider

        if ($request->ajax()) {
            $recordsArray = $records->map(function ($record) use ($defaultCurrency, $avgProviderReviews) {
                // Get the first service image if available
                $firstServiceImage = $record->productImages->isNotEmpty()
                    ? asset('images/product_images/' . $record->productImages->first()->product_image)
                    : '';


                return [
                    'product_id' => $record->product_id,
                    'product_name' => $record->product_name ?? '',
                    'product_description' => $record->product_description ?? '',
                    'product_price' => $record->product_price ?? '',
                    'product_image' => $firstServiceImage, // Only first image
                    'product_discount_price' => $record->product_discount_price ?? '',
                    'is_features' => $record->is_features,
                    'status' => $record->status,
                    'c_name' => $record->category->c_name ?? '',
                    'category_url' => $record->category && $record->category->id
                        ? route('category-edit', $record->category->id) // Pass the vendor id
                        : null,
                        
                    'vendor' => [
                        'firstname' => $record->vendor->firstname ?? '',
                        'lastname' => $record->vendor->lastname ?? '',
                        'email' => $record->vendor->email ?? '',
                        'avg_provider_review' => number_format($avgProviderReviews[$record->vendor->id] ?? 0.0, 1), // Correctly handling average rating
                        'profile_pic' => $record->vendor && $record->vendor->profile_pic ? asset('images/user/' . $record->vendor->profile_pic) : '',
                        'profile_url' => $record->vendor && $record->vendor->id
                            ? route('provider-view', $record->vendor->id) // Pass the vendor id
                            : null,
                    ],

                    'edit_url' => route('product-edit', $record->product_id),
                    'currency' => $defaultCurrency,
                ];
            });

            return response()->json(['records' => $recordsArray]);
        }

        // Attach avg review ratings to users collection
        $records->getCollection()->transform(function ($record) use ($avgProviderReviews) {
            // Ensure provider exists before assigning avg review
            if ($record->vendor) {
                $record->vendor->avg_provider_review = number_format($avgProviderReviews[$record->vendor->id] ?? 0.0, 1);
            }

            return $record;
        });


        return view('product-list', compact('records', 'search', 'defaultCurrency'));
    }


    // addProduct
    public function addProduct()
    {
        $services = Service::all();
        $categories = Category::all();
        $products = Product::all();
        $vendors = User::where('people_id', 1)->get();
        $defaultCurrency = SiteSetup::first()->default_currency;

        return view('product-add', [
            'services' => $services,
            'categories' => $categories,
            'products' => $products,
            'vendors' => $vendors,
            'defaultCurrency' => $defaultCurrency,
        ]);
    }


    // saveProduct
    public function saveProduct(Request $request)
    {
        $rules = [
            'product_name' => 'required',
            'product_description' => 'required',
            'vid' => 'required',
            'product_price' => 'required',
            'product_discount_price' => 'nullable|lte:product_price',
            'product_image' => 'required',
            'status' => 'required',
        ];

        $customMessages = [
            'product_name.required' => 'Please enter the product name.',
            'product_description.required' => 'Please enter the product description.',
            'vid.required' => 'Please select the provider.',
            'product_price.required' => 'Please enter the product price.',
            'product_discount_price.lte' => 'The discount price cannot be greater than the product price.',
            'product_image.required' => 'Please upload at least one image.',
            'status.required' => 'Please select the product status.',
        ];

        $this->validate($request, $rules, $customMessages);

        // Save the service
        $service = new Product();
        $service->product_name = $request->input('product_name');
        $service->product_description = $request->input('product_description'); // Store as HTML
        $service->vid = $request->input('vid');
        $service->service_id = is_array($request->input('service_id')) ? implode(',', $request->input('service_id')) : '';
        $service->product_price = $request->input('product_price');
        $service->product_discount_price = $request->input('product_discount_price');
        $service->is_features = $request->has('is_features') ? 1 : 0;
        $service->status = $request->input('status');
        $service->save();

        // Handle multiple service images upload
        if ($request->hasfile('product_image')) {
            foreach ($request->file('product_image') as $file) {
                $fileName = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('images/product_images'), $fileName);
                $service->productImages()->create([
                    'product_id' => $service->product_id,
                    'product_image' => $fileName
                ]);
            }
        }

        return redirect()->route('product-list')->with('message', 'Product added successfully');
    }



    // editProduct
    public function editProduct($id)
    {
        $data = Product::with('productImages')->find($id);
        $vendors = User::where('people_id', 1)->get();
        $categories = Category::all();
        $products = Product::all();
        $services = Service::all();
        $defaultCurrency = SiteSetup::first()->default_currency;

        return view('product-edit',  compact('categories', 'data', 'services', 'vendors', 'products', 'defaultCurrency'));
    }


    // updateProduct
    public function updateProduct($id, Request $request)
    {

        $service = Product::find($id);
        $service->product_name = $request->input('product_name');
        $service->product_description = $request->input('product_description'); // Store as HTML
        $service->vid = $request->input('vid');

        // Ensure 'service_id' is an array before imploding
        if (is_array($request->input('service_id'))) {
            $service->service_id = implode(',', $request->input('service_id'));
        } else {
            $service->service_id = '';
        }


        $service->product_price = $request->input('product_price');
        $service->product_discount_price = $request->input('product_discount_price');
        $service->is_features = $request->has('is_features') ? 1 : 0;
        $service->status = $request->input('status'); // Status should be directly 0 or 1
        $service->save();

        // Handle multiple service images upload
        if ($request->hasfile('product_image')) {
            foreach ($request->file('product_image') as $file) {
                $fileName = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('images/product_images'), $fileName);
                $service->productImages()->create([
                    'product_id' => $service->product_id,
                    'product_image' => $fileName
                ]);
            }
        }

        return redirect()->route('product-list')->with('message', 'Product updated successfully');
    }


    // imageDeleteProduct
    public function imageDeleteProduct($id)
    {
        $data = ProductImages::find($id);
        $image_path = public_path('images/product_images/' . $data->product_image);
        if (file_exists($image_path)) {
            unlink($image_path);
        }
        $data->delete();
        return response()->json(['success' => 'sucess']);
    }


    public function getServices($providerId)
    {
        // Fetch services based on the provider ID
        $services = Service::where('v_id', $providerId)->get();

        // Check if services are found
        if ($services->isEmpty()) {
            return response()->json([], 200); // Return an empty array with status 200
        }

        // Ensure the correct structure is returned for the JavaScript
        return response()->json($services);
    }

    // deleteProduct
    public function deleteProduct($id)
    {
        // Find the service by ID
        $service = Product::find($id);
        if (!$service) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        ProductImages::where('product_id', $id)->delete();
        $service->delete();

        return response()->json(['message' => 'Product deleted successfully']);
    }


    // ChangeProductStatus
    public function ChangeProductStatus($id)
    {
        // Check the current status
        $currentType = Product::where('product_id', $id)->value('is_features');

        // Toggle the status
        $status = $currentType == 1 ? 0 : 1;

        // Update the status
        $updated = Product::where('product_id', $id)->update(['is_features' => $status]);

        if ($updated) {
            return response()->json(['message' => 'Status changed successfully']);
        } else {
            return response()->json(['message' => 'Failed to change status'], 500);
        }
    }


    // changeProductListStatus 
    public function
    changeProductListStatus($id)
    {
        // Check the current status
        $currentType = Product::where('product_id', $id)->value('status');

        // Toggle the status (1 -> 0, 0 -> 1)
        $status = $currentType == 1 ? 0 : 1;

        // Update the status
        $updated = Product::where('product_id', $id)->update(['status' => $status]);

        if ($updated) {
            return response()->json(['message' => 'Status changed successfully']);
        } else {
            return response()->json(['message' => 'Failed to change status'], 500);
        }
    }
}
