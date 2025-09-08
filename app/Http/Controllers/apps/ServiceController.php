<?php

namespace App\Http\Controllers\apps;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class ServiceController extends Controller
{

  public function index()
  {
    $services = Service::all();
    return view('content.apps.services-list', compact('services'));
  }

  // Datatables
  public function getServiceData(Request $request)
  {
    $draw = $request->get('draw');
    $start = $request->get("start");
    $rowperpage = $request->get("length");

    $columnIndex_arr = $request->get('order');
    $columnName_arr = $request->get('columns');
    $order_arr = $request->get('order');
    $search_arr = $request->get('search');

    $columnIndex = $columnIndex_arr[0]['column'];
    $columnName = $columnName_arr[$columnIndex]['data'];
    $columnSortOrder = $order_arr[0]['dir'];

    $searchValue = $search_arr['value'];
    $totalRecords = Service::select('count(*) as allcount')->count();
    $totalRecordswithFilter = Service::select('count(*) as allcount')->where('service_name', 'like', '%' . $searchValue . '%')->count();

    $records = Service::orderBy($columnName, $columnSortOrder)
      ->where(function ($query) use ($searchValue) {
        $query->where('service_name', 'like', '%' . $searchValue . '%');
      })
      ->skip($start)
      ->take($rowperpage)
      ->get();

    $data_arr = array();
    foreach ($records as $record) {
      $provider = User::find($record->v_id);
      if ($provider) {
        $provider_name = $provider->firstname . ' ' . $provider->lastname;
        $provider_profile_pic = $provider->profile_pic;
        $provider_email = $provider->email;
      } else {
        $provider_name = null;
        $provider_profile_pic = null;
        $provider_email = null;
      }

      $categoryname = Category::where('id', $record->cat_id)->value('c_name');
      $data_arr[] = array(
        "id" => $record->id,
        "service_name" => $record->service_name,
        "service_price" => $record->service_price,
        "v_id" => $provider_name,
        "provider_profile_pic" => $provider_profile_pic,
        "provider_email" => $provider_email,
        "cat_id" => $categoryname,
        "service_description" => $record->service_description,
        "created_date" => $record->created_date,
        "service_image" => $record->service_image,
        "status" => $record->status,
        "action" => ''
      );
    }

    $response = array(
      "draw" => intval($draw),
      "iTotalRecords" => $totalRecords,
      "iTotalDisplayRecords" => $totalRecordswithFilter,
      "aaData" => $data_arr
    );

    echo json_encode($response);
    exit;
  }


  // Add service
  public function addService()
  {
    $categories = Category::all();
    $vendors = User::all();
    $subcategorys = SubCategory::all();
    return view('content.apps.services-add', compact('categories', 'vendors', 'subcategorys'));
  }

  public function saveService(Request $request)
  {
    $rules = [
      'service_name' => 'required',
      'cat_id' => 'required',
      'status' => 'nullable',
      'service_description' => 'required',
      'service_phone' => 'required',
      'service_price' => 'required',
      'service_image.*' => 'required|image|mimes:jpeg,png,jpg,gif',
      'day' => 'required|array',
      'open_time' => 'required',
      'close_time' => 'required',
      'price_unit' => 'required',
      'slot_book' => 'required',
      'address' => 'required',
    ];

    $customMessages = [
      'service_name.required' => 'Please enter service name.',
      'service_phone.required' => 'Please enter phone number.',
      'service_price.required' => 'Please enter service price.',
    ];

    $this->validate($request, $rules, $customMessages);

    $service = new Service;
    $service->service_name = $request->input('service_name');
    $service->service_description = strip_tags($request->input('service_description'));
    $service->status = $request->input('status', '0');
    $service->service_phone = $request->input('service_phone');
    $service->service_price = $request->input('service_price');
    $service->cat_id = $request->input('cat_id');
    $service->day = implode(',', $request->input('day'));
    $service->open_time = $request->input('open_time');
    $service->close_time = $request->input('close_time');
    $service->promo_offer = $request->input('promo_offer');
    $service->price_unit = $request->input('price_unit');
    $service->slot_book = $request->input('slot_book') == '24' ? 'Full Day' : $request->input('slot_book') . ' Hours';


    $address = $request->input('address');
    $address = str_replace(',,', ',', $address);
    $address = str_replace(', ,', ',', $address);
    $address = str_replace(" ", "", $address);

    $json = file_get_contents('https://maps.google.com/maps/api/geocode/json?address=' . $address . '&key=AIzaSyAMZ4GbRFYSevy7tMaiH5s0JmMBBXc0qBA');
    $json1 = json_decode($json);

    if (isset($json1->results)) {
      $service->lat = ($json1->results[0]->geometry->location->lat);
      $service->lon = ($json1->results[0]->geometry->location->lng);
    }


    $service->v_id = $request->input('v_id', auth()->id());
    $service->subc_id = $request->input('subc_id', auth()->id());

    if ($request->hasFile('service_image')) {
      $images = $request->file('service_image');
      $imagePaths = [];

      foreach ($images as $image) {
        $imageName = uniqid() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('assets/images/service'), $imageName);
        $imagePaths[] = $imageName;
      }

      $service->service_image = implode('::::', $imagePaths);
    }

    $service->service_address = $address;
    $service->created_date = now();

    $service->save();
    return redirect()->route('services-list')->with('message', 'Service added successfully');
  }


  // Update Service
  public function editService($id)
  {
    $service = Service::where('id', $id)->first();
    $serviceOld = Service::get();

    if (!$service) {
      return redirect()->route('services-list')->with('error', 'Service not found.');
    }

    $categories = Category::all();
    $vendors = User::all();
    $subcategorys = SubCategory::all();
    $existingDays = explode(',', $service->day);
    $service->slot_book = $service->slot_book;
    $existingOpenTime = $service->open_time;
    $existingCloseTime = $service->close_time;
    $existingHours = explode(',', $service->slot_book);
    $existingImages = explode("::::", $service->service_image);
    $lat = $service->lat;
    $lon = $service->lon;

    return view('content.apps.services-edit', compact('service', 'categories', 'vendors', 'subcategorys',  'existingDays', 'existingOpenTime', 'existingCloseTime', 'existingImages', 'existingHours'));
  }


  public function updateService($id, Request $request)
  {
    $service = Service::where('id', $id)->first();
    if (!$service) {
      return response()->json(['success' => false, 'message' => 'Service not found']);
    }

    // Update basic fields
    $service->service_name = $request->input('service_name');
    $service->service_description = strip_tags($request->input('service_description'));
    $service->status = $request->input('status', '0');
    $service->service_phone = $request->input('service_phone');
    $service->service_price = $request->input('service_price');
    $service->cat_id = $request->input('cat_id');
    $service->v_id = $request->input('v_id');
    $service->subc_id = $request->input('subc_id');
    $service->day = implode(',', $request->input('day'));
    $service->price_unit = $request->input('price_unit');
    $service->open_time = $request->input('open_time');
    $service->close_time = $request->input('close_time');
    $service->promo_offer = $request->input('promo_offer');
    $service->slot_book = $request->input('slot_book');
    $service->service_address = $request->input('address');

    // Handle image upload
    if ($request->hasFile('service_image')) {
      $images = $request->file('service_image');
      $imagePaths = [];

      foreach ($images as $image) {
        $imageName = uniqid() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('assets/images/service'), $imageName);
        $imagePaths[] = $imageName;
      }

      $service->service_image = implode('::::', $imagePaths);
    }


    // Handle geocoding for latitude and longitude
    $address = str_replace(" ", "+", $request->input('address'));
    $json = file_get_contents('https://maps.google.com/maps/api/geocode/json?address=' . $address . '&key=AIzaSyAMZ4GbRFYSevy7tMaiH5s0JmMBBXc0qBA');
    $json1 = json_decode($json);
    if (isset($json1->results[0])) {
      $service->lat = $json1->results[0]->geometry->location->lat;
      $service->lon = $json1->results[0]->geometry->location->lng;
    }

    $service->save();
    return redirect()->route('services-list')->with('message', 'Service updated successfully');
  }


  // Delete Service
  public function deleteService($id)
  {
    Service::find($id)->delete();
    return response()->json(['message' => 'Service deleted successfully', 'id' => $id]);
  }


  // Changeproviderfeature
  public function Changeproviderfeature($id, Request $request)
  {
    if ($request->status == 1) {
      $status = 0;
      $data = Service::where('id', $id)->update(['status' => $status]);
      return response()->json(['message' => 'Status changed successfully', 'data' => $data]);
    } else {
      $status = 1;
      $data = Service::where('id', $id)->update(['status' => $status]);
      return response()->json(['message' => 'Status changed successfully', 'data' => $data]);
    }
  }
}
