<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Service;
use App\Models\ServiceLike;
use App\Models\ServiceProof;
use App\Models\ServiceReview;
use App\Models\ServiceImages;
use App\Models\SiteSetup;
use App\Models\AddonProduct;
use App\Models\SubCategory;
use Illuminate\Support\Facades\File;
use App\Models\User;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    // index
    public function index(Request $request)
    {
        $search = $request->input('search');

        // Fetch the default currency from SiteSetup
        $defaultCurrency = SiteSetup::first()->default_currency;

        $records = Service::with(['category', 'serviceImages', 'vendor' => function ($query) {
            $query->select('id', 'firstname', 'lastname', 'email', 'profile_pic');
        }])
            ->when($search, function ($query, $search) {
                $query->where('service_name', 'like', "%{$search}%");
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
                $firstServiceImage = $record->serviceImages->isNotEmpty()
                    ? asset('images/service_images/' . $record->serviceImages->first()->service_images)
                    : '';


                return [
                    'id' => $record->id,
                    'service_name' => $record->service_name ?? '',
                    'service_description' => $record->service_description ?? '',
                    'service_price' => $record->service_price ?? '',
                    'service_images' => $firstServiceImage, // Only first image
                    'service_discount_price' => $record->service_discount_price ?? '',
                    'is_features' => $record->is_features,
                    'duration' => $record->duration,
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

                    'view_url' => route('service-view', $record->id),
                    'edit_url' => route('service-edit', $record->id),
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


        return view('service-list', compact('records', 'search', 'defaultCurrency'));
    }


    // addService
    public function addService()
    {

        $subcategories = SubCategory::all();
        $categories = Category::all();
        $products = Product::all();
        $vendors = User::where('people_id', 1)->get();
        // Fetch the default currency from SiteSetup
        $defaultCurrency = SiteSetup::first()->default_currency;

        return view('service-add', [
            'subcategories' => $subcategories,
            'categories' => $categories,
            'products' => $products,
            'vendors' => $vendors,
            'defaultCurrency' => $defaultCurrency,
        ]);
    }


    // saveService
    public function saveService(Request $request)
    {
        $rules = [
            'service_name' => 'required',
            'service_description' => 'required',
            'v_id' => 'required',
            'cat_id' => 'required',
            'duration' => 'required',
            'service_price' => 'required',
            'service_discount_price' => 'nullable|lte:service_price',
            'service_images' => 'required',
            'status' => 'required',
            'address' => 'required',
        ];

        $customMessages = [
            'service_name.required' => 'Please enter the service name.',
            'service_description.required' => 'Please enter the service description.',
            'v_id.required' => 'Please select the provider.',
            'cat_id.required' => 'Please select a category.',
            'duration.required' => 'Please enter the service duration.',
            'service_price.required' => 'Please enter the service price.',
            'service_discount_price.lte' => 'The discount price cannot be greater than the service price.',
            'service_images.required' => 'Please upload at least one image.',
            'status.required' => 'Please select the service status.',
            'address.required' => 'Please enter the address.',
        ];

        $this->validate($request, $rules, $customMessages);


        // Save the service
        $service = new Service();
        $service->service_name = $request->input('service_name');
        $service->service_description = $request->input('service_description'); // Store as HTML
        $service->v_id = $request->input('v_id');
        $service->cat_id = $request->input('cat_id');
        $service->res_id = is_array($request->input('res_id')) ? implode(',', $request->input('res_id')) : '';
        $service->duration = $request->input('duration');
        $service->service_price = $request->input('service_price');
        $service->service_discount_price = $request->input('service_discount_price');
        $service->is_features = $request->has('is_features') ? 1 : 0;
        $service->status = $request->input('status');
        $service->product_id = $request->input('product_id');
        $service->meta_title = $request->input('meta_title');
        $service->meta_description = $request->input('meta_description');
        $service->address = $request->input('address');


        $address = $request->input('address');
        $address = str_replace(',,', ',', $address);
        $address = str_replace(', ,', ',', $address);
        $address = trim($address);

        $json = file_get_contents('https://maps.google.com/maps/api/geocode/json?address=' . urlencode($address) . '&key=AIzaSyAMZ4GbRFYSevy7tMaiH5s0JmMBBXc0qBA');
        $json1 = json_decode($json);

        if (isset($json1->results[0])) {
            $geometry = $json1->results[0]->geometry->location;
            $service->lat = $geometry->lat;
            $service->lon = $geometry->lng;
        }
        $service->save();

        // If product_id is provided, insert into addon_product table
        if ($request->filled('product_id')) {
            AddonProduct::create([
                'service_id' => $service->id,
                'vid' => $request->input('v_id'),
                'product_id' => $request->input('product_id'),
            ]);
        }

        // Handle multiple service images upload
        if ($request->hasfile('service_images')) {
            foreach ($request->file('service_images') as $file) {
                $fileName = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('images/service_images'), $fileName);
                $service->serviceImages()->create([
                    'service_id' => $service->id,
                    'service_images' => $fileName
                ]);
            }
        }

        $service->address = $address;


        return redirect()->route('service-list')->with('message', 'Service added successfully');
    }



    // editService
    public function editService($id)
    {
        $data = Service::with('ServiceImages')->find($id);
        $vendors = User::where('people_id', 1)->get();
        $categories = Category::all();
        $products = Product::all();
        $subcategory = SubCategory::all();
        $defaultCurrency = SiteSetup::first()->default_currency;

        return view('service-edit',  compact('categories', 'data', 'subcategory', 'vendors', 'products', 'defaultCurrency'));
    }


    // updateService
    public function updateService($id, Request $request)
    {

        $rules = [
            'address' => 'required',
        ];

        $customMessages = [
            'address.required' => 'Please enter the address.',
        ];

        $this->validate($request, $rules, $customMessages);

        $service = Service::find($id);
        $service->service_name = $request->input('service_name');
        $service->service_description = $request->input('service_description'); // Store as HTML
        $service->v_id = $request->input('v_id');
        $service->cat_id = $request->input('cat_id');

        // Ensure 'res_id' is an array before imploding
        if (is_array($request->input('res_id'))) {
            $service->res_id = implode(',', $request->input('res_id'));
        } else {
            $service->res_id = '';
        }

        $service->duration = $request->input('duration');
        $service->service_price = $request->input('service_price');
        $service->service_discount_price = $request->input('service_discount_price');
        $service->is_features = $request->has('is_features') ? 1 : 0;
        $service->status = $request->input('status'); // Status should be directly 0 or 1
        $service->product_id = $request->input('product_id');
        $service->meta_title = $request->input('meta_title');
        $service->meta_description = $request->input('meta_description');
        $service->address = $request->input('address');

        // Handle geocoding for latitude and longitude
        $address = str_replace(" ", "+", $request->input('address'));
        $json = file_get_contents('https://maps.google.com/maps/api/geocode/json?address=' . $address . '&key=AIzaSyAMZ4GbRFYSevy7tMaiH5s0JmMBBXc0qBA');
        $json1 = json_decode($json);
        if (isset($json1->results[0])) {
            $service->lat = $json1->results[0]->geometry->location->lat;
            $service->lon = $json1->results[0]->geometry->location->lng;
        }
        $service->save();

        // If product_id is provided, update or insert into addon_product table
        if ($request->filled('product_id')) {
            AddonProduct::updateOrCreate(
                ['service_id' => $service->id],
                [
                    'vid' => $request->input('v_id'),
                    'product_id' => $request->input('product_id'),
                ]
            );
        }

        // Handle multiple service images upload
        if ($request->hasfile('service_images')) {
            foreach ($request->file('service_images') as $file) {
                $fileName = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('images/service_images'), $fileName);
                $service->serviceImages()->create([
                    'service_id' => $service->id,
                    'service_images' => $fileName
                ]);
            }
        }

        return redirect()->route('service-list')->with('message', 'Service updated successfully');
    }


    // viewService
    public function viewService($id)
    {
        $data = Service::find($id);
        $vendors = User::where('people_id', 1)->get();
        $categories = Category::all();
        $products = Product::all();
        $subcategory = SubCategory::all();
        return view('service-view',  compact('categories', 'data', 'subcategory', 'vendors', 'products'));
    }


    // ChangeServiceStatus
    public function ChangeServiceStatus($id)
    {
        // Check the current status
        $currentType = Service::where('id', $id)->value('is_features');

        // Toggle the status
        $status = $currentType == 1 ? 0 : 1;

        // Update the status
        $updated = Service::where('id', $id)->update(['is_features' => $status]);

        if ($updated) {
            return response()->json(['message' => 'Status changed successfully']);
        } else {
            return response()->json(['message' => 'Failed to change status'], 500);
        }
    }


    // deleteService
    public function deleteService($id)
    {
        // Find the service by ID
        $service = Service::find($id);
        if (!$service) {
            return response()->json(['message' => 'Service not found'], 404);
        }

        ServiceLike::where('service_id', $id)->delete();
        ServiceReview::where('service_id', $id)->delete();
        $service->delete();

        return response()->json(['message' => 'Service deleted successfully']);
    }


    // Controller - getSubcategories
    public function getSubcategories($categoryId)
    {
        // Fetch subcategories based on the category ID
        $subcategories = SubCategory::where('cat_id', $categoryId)->get();

        // Check if subcategories are found
        if ($subcategories->isEmpty()) {
            return response()->json([], 200); // Return an empty array with status 200
        }

        // Ensure the correct structure is returned for the JavaScript
        return response()->json($subcategories);
    }


    // imageDeleteService
    public function imageDeleteService($id)
    {
        $data = ServiceImages::find($id);
        $image_path = public_path('images/service_images/' . $data->service_images);
        if (file_exists($image_path)) {
            unlink($image_path);
        }
        $data->delete();
        return response()->json(['success' => 'sucess']);
    }


    public function getProductsByVendor($v_id)
    {
        // Fetching products for the given vendor ID (vid)
        $products = Product::where('vid', $v_id)->get();

        return response()->json($products);  // Returning as JSON response
    }



    // changeServiceLinkStatus 
    public function
    changeServiceLinkStatus($id)
    {
        // Check the current status
        $currentType = Service::where('id', $id)->value('status');

        // Toggle the status (1 -> 0, 0 -> 1)
        $status = $currentType == 1 ? 0 : 1;

        // Update the status
        $updated = Service::where('id', $id)->update(['status' => $status]);

        if ($updated) {
            return response()->json(['message' => 'Status changed successfully']);
        } else {
            return response()->json(['message' => 'Failed to change status'], 500);
        }
    }
}
