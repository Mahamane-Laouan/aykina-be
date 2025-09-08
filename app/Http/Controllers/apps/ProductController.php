<?php

namespace App\Http\Controllers\apps;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\SubCategory;
use App\Models\User;
use Illuminate\Http\Request;

class ProductController extends Controller
{
  public function index()
  {
    $services = Product::all();
    return view('content.apps.products-list', compact('services'));
  }

  // Datatables
  public function getProductData(Request $request)
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
    $totalRecords = Product::select('count(*) as allcount')->count();
    $totalRecordswithFilter = Product::select('count(*) as allcount')->where('product_name', 'like', '%' . $searchValue . '%')->count();

    $records = Product::orderBy($columnName, $columnSortOrder)
      ->where(function ($query) use ($searchValue) {
        $query->where('product_name', 'like', '%' . $searchValue . '%');
      })
      ->skip($start)
      ->take($rowperpage)
      ->get();

    $data_arr = array();
    foreach ($records as $record) {
      $provider = User::find($record->vid);
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
        "product_id" => $record->product_id,
        "product_name" => $record->product_name,
        "product_price" => $record->product_price,
        "vid" => $provider_name,
        "provider_profile_pic" => $provider_profile_pic,
        "provider_email" => $provider_email,
        "cat_id" => $categoryname,
        "product_description" => $record->product_description,
        "product_create_date" => $record->product_create_date,
        "product_image" => $record->product_image,
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

  // Add product
  public function addProduct()
  {
    $categories = Category::all();
    $vendors = User::all();
    $subcategorys = SubCategory::all();
    return view('content.apps.products-add', compact('categories', 'vendors', 'subcategorys'));
  }

  public function saveProduct(Request $request)
  {
    $rules = [
      'product_name' => 'required',
      'cat_id' => 'required',
      'status' => 'nullable',
      'product_description' => 'required',
      'product_discount_price' => 'required',
      'product_price' => 'required',
      'product_image.*' => 'required|image|mimes:jpeg,png,jpg,gif,webp',
    ];

    $customMessages = [
      'product_name.required' => 'Please enter product name.',
      'product_discount_price.required' => 'Please enter discount price.',
      'product_price.required' => 'Please enter product price.',
    ];

    $this->validate($request, $rules, $customMessages);

    $service = new Product();
    $service->product_name = $request->input('product_name');
    $service->product_description = strip_tags($request->input('product_description'));
    $service->status = $request->input('status', '0');
    $service->product_discount_price = $request->input('product_discount_price');
    $service->product_price = $request->input('product_price');
    $service->cat_id = $request->input('cat_id');


    $service->vid = $request->input('vid', auth()->id());
    $service->subc_id = $request->input('subc_id', auth()->id());

    if ($request->hasFile('product_image')) {
      $images = $request->file('product_image');
      $imagePaths = [];

      foreach ($images as $image) {
        $imageName = uniqid() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('assets/images/product'), $imageName);
        $imagePaths[] = $imageName;
      }

      $service->product_image = implode('::::', $imagePaths);
    }

    $service->product_create_date = now();

    $service->save();
    return redirect()->route('products-list')->with('message', 'Product added successfully');
  }


  // Update product
  public function editProduct($id)
  {
    $service = Product::where('product_id', $id)->first();
    $serviceOld = Product::get();

    if (!$service) {
      return redirect()->route('products-list')->with('error', 'product not found.');
    }

    $categories = Category::all();
    $vendors = User::all();
    $subcategorys = SubCategory::all();
    $existingImages = explode("::::", $service->product_image);

    return view('content.apps.products-edit', compact('service', 'categories', 'vendors', 'subcategorys',   'existingImages'));
  }


  public function updateProduct($id, Request $request)
  {
    $service = Product::where('product_id', $id)->first();
    if (!$service) {
      return response()->json(['success' => false, 'message' => 'Service not found']);
    }

    // Update basic fields
    $service->product_name = $request->input('product_name');
    $service->product_description = strip_tags($request->input('product_description'));
    $service->status = $request->input('status', '0');
    $service->product_discount_price = $request->input('product_discount_price');
    $service->product_price = $request->input('product_price');
    $service->cat_id = $request->input('cat_id');
    $service->vid = $request->input('vid');
    $service->subc_id = $request->input('subc_id');

    // Handle image upload
    if ($request->hasFile('product_image')) {
      $images = $request->file('product_image');
      $imagePaths = [];

      foreach ($images as $image) {
        $imageName = uniqid() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('assets/images/product'), $imageName);
        $imagePaths[] = $imageName;
      }

      $service->product_image = implode('::::', $imagePaths);
    }

    $service->save();
    return redirect()->route('products-list')->with('message', 'Product updated successfully');
  }


  // Delete Service
  public function deleteProduct($id)
  {
    Product::find($id)->delete();
    return response()->json(['message' => 'Product deleted successfully', 'id' => $id]);
  }


  // Changeproviderfeature
  public function Changeproductfeature($product_id, Request $request)
  {
    if ($request->status == 1) {
      $status = 0;
      $data = Product::where('product_id', $product_id)->update(['status' => $status]);
      return response()->json(['message' => 'Status changed successfully', 'data' => $data]);
    } else {
      $status = 1;
      $data = Product::where('product_id', $product_id)->update(['status' => $status]);
      return response()->json(['message' => 'Status changed successfully', 'data' => $data]);
    }
  }
}
