<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImages;
use Illuminate\Support\Facades\Auth;
use App\Models\Service;
use App\Models\SiteSetup;
use App\Models\User;
use Illuminate\Http\Request;

class ProviderProductController extends Controller
{
    // index
    public function index(Request $request)
    {
        $search = $request->input('search');

        // Fetch the default currency from SiteSetup
        $defaultCurrency = SiteSetup::first()->default_currency;

        // Get the logged-in admin user
        $user = Auth::guard('admin')->user();

        $records = Product::with(['category',  'productImages', 'vendor' => function ($query) {
            $query->select('id', 'firstname', 'lastname', 'email', 'profile_pic');
        }])
            ->when($search, function ($query, $search) {
                $query->where('product_name', 'like', "%{$search}%");
            })
            ->where('vid', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);


        if ($request->ajax()) {
            $recordsArray = $records->map(function ($record) use ($defaultCurrency) {
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
                    'currency' => $defaultCurrency,
                    'edit_url' => route('providerproduct-edit', $record->product_id),
                ];
            });

            return response()->json(['records' => $recordsArray]);
        }



        return view('providerproduct-list', compact('records', 'search', 'defaultCurrency'));
    }


    // addProviderProduct
    public function addProviderProduct()
    {
        $user = Auth::guard('admin')->user(); // Get the logged-in user
        $providerId = $user->id; // Logged-in provider's ID

        // Fetch services related to the provider
        $services = Service::where('v_id', $providerId)
            ->select('id', 'service_name')
            ->get();

        $categories = Category::all();
        $defaultCurrency = SiteSetup::first()->default_currency;


        return view('providerproduct-add', [
            'services' => $services,
            'categories' => $categories,
            'defaultCurrency' => $defaultCurrency,

        ]);
    }


    // saveProviderProduct
    public function saveProviderProduct(Request $request)
    {
        $rules = [
            'product_name' => 'required',
            'product_description' => 'required',
            'product_price' => 'required',
            'product_discount_price' => 'nullable|lte:product_price',
            'product_image.*' => 'required',
            'status' => 'required',
        ];

        $customMessages = [
            'product_name.required' => 'Please enter the product name.',
            'product_description.required' => 'Please enter the product description.',
            'product_price.required' => 'Please enter the product price.',
            'product_discount_price.lte' => 'The discount price cannot be greater than the product price.',
            'product_image.*.required' => 'Please upload at least one image.',
            'status.required' => 'Please select the product status.',
        ];

        $this->validate($request, $rules, $customMessages);

        $user = Auth::guard('admin')->user(); // Get the logged-in user

        // Save the service
        $service = new Product();
        $service->product_name = $request->input('product_name');
        $service->product_description = $request->input('product_description'); // Store as HTML
        $service->vid = $user->id; // Assign the logged-in provider's ID
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

        return redirect()->route('providerproduct-list')->with('message', 'Product added successfully');
    }


    // editProviderProduct
    public function editProviderProduct($id)
    {
        $data = Product::with('productImages')->find($id);
        $user = Auth::guard('admin')->user(); // Get the logged-in user
        $providerId = $user->id; // Logged-in provider's ID

        // Fetch services related to the provider
        $services = Service::where('v_id', $providerId)
            ->select('id', 'service_name')
            ->get();

        $categories = Category::all();
        $defaultCurrency = SiteSetup::first()->default_currency;


        return view('providerproduct-edit',  compact('categories', 'data', 'services', 'defaultCurrency'));
    }



    // updateProviderProduct
    public function updateProviderProduct($id, Request $request)
    {

        $service = Product::find($id);
        $service->product_name = $request->input('product_name');
        $service->product_description = $request->input('product_description'); // Store as HTML

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

        return redirect()->route('providerproduct-list')->with('message', 'Product updated successfully');
    }


    // imageDeleteProviderProduct
    public function imageDeleteProviderProduct($id)
    {
        $data = ProductImages::find($id);
        $image_path = public_path('images/product_images/' . $data->product_image);
        if (file_exists($image_path)) {
            unlink($image_path);
        }
        $data->delete();
        return response()->json(['success' => 'sucess']);
    }


    // deleteProviderProduct
    public function deleteProviderProduct($id)
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


    // ChangeProviderProductStatus
    public function ChangeProviderProductStatus($id)
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



    // changeProviderProductListStatus 
    public function
    changeProviderProductListStatus($id)
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
