<?php

namespace App\Http\Controllers\apps;

use App\Http\Controllers\Controller;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VendorController extends Controller
{
  public function index()
  {
    $vendors = Vendor::all();
    return view('content.apps.vendors-list', compact('vendors'));
  }


  // Datatables
  public function getVendorData(Request $request)
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
    $totalRecords = Vendor::select('count(*) as allcount')->count();
    $totalRecordswithFilter = Vendor::select('count(*) as allcount')->where('uname', 'like', '%' . $searchValue . '%')->count();

    $records = Vendor::orderBy($columnName, $columnSortOrder)
      ->where(function ($query) use ($searchValue) {
        $query->where('uname', 'like', '%' . $searchValue . '%');
      })
      ->skip($start)
      ->take($rowperpage)
      ->get();

    $data_arr = array();
    foreach ($records as $record) {
      $data_arr[] = array(
        "id" => $record->id,
        "uname" => $record->uname,
        "fname" => $record->fname,
        "lname" => $record->lname,
        "email" => $record->email,
        "profile_image" => $record->profile_image,
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



  // Add vendor
  public function addVendor()
  {
    return view('content.apps.vendors-add');
  }


  public function saveVendor(Request $request)
  {

    $rules = [
      'fname' => 'required',
      'lname' => 'required',
      'uname' => 'required',
      'email' => 'required|email',
      'password' => 'required|confirmed',
      'profile_image' => 'required',
    ];

    $customMessages = [
      'fname.required' => 'Please enter first name.',
      'lname.required' => 'Please enter last name.',
      'uname.required' => 'Please enter username.',
      'email.required' => 'Please enter email.',
      'password.required' => 'Please enter password.',
    ];

    $this->validate($request, $rules, $customMessages);

    $vendor = new Vendor;
    $vendor->fname = $request->input('fname');
    $vendor->email = $request->input('email');
    $vendor->lname = $request->input('lname');
    $vendor->uname = $request->input('uname');
    $vendor->password = bcrypt($request->input('password'));

    if ($request->hasFile('profile_image')) {
      $image = $request->file('profile_image');
      $imageName = time() . '.' . $image->getClientOriginalExtension();
      $image->move(public_path('assets/images'), $imageName);
      $vendor->profile_image = $imageName;
    }

    $vendor->save();
    return redirect()->route('vendors-list')->with('message', 'Vendor added successfully');
  }

  // Delete Vendor
  public function deleteVendor($id)
  {
    $vendor = Vendor::find($id);

    if (!$vendor) {
      return response()->json(['success' => false]);
    }

    $vendor->delete();
    return response()->json(['success' => true]);
  }
}
