<?php

namespace App\Http\Controllers\apps;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;

class BannerController extends Controller
{

  public function index()
  {
    $banners = Banner::all();
    return view('content.apps.banners-list', compact('banners'));
  }

  // Datatables
  public function getBannerData(Request $request)
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
    $totalRecords = Banner::select('count(*) as allcount')->count();
    $totalRecordswithFilter = Banner::select('count(*) as allcount')->where('banners_name', 'like', '%' . $searchValue . '%')->count();

    $records = Banner::orderBy($columnName, $columnSortOrder)
      ->where(function ($query) use ($searchValue) {
        $query->where('banners_name', 'like', '%' . $searchValue . '%');
      })
      ->skip($start)
      ->take($rowperpage)
      ->get();

    $data_arr = array();
    foreach ($records as $record) {
      $data_arr[] = array(
        "id" => $record->id,
        "banners_name" => $record->banners_name,
        "image" => $record->image,
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


  // Add banner
  public function addBanner()
  {
    return view('content.apps.banners-add');
  }

  public function saveBanner(Request $request)
  {
    $rules = [
      'banners_name' => 'required',
      'image' => 'required',
    ];

    $customMessages = [
      'banners_name.required' => 'Please enter banner name.',
    ];

    $this->validate($request, $rules, $customMessages);

    $banner = new Banner;
    $banner->banners_name = $request->input('banners_name');

    if ($request->hasFile('image')) {
      $image = $request->file('image');
      $imageName = time() . '.' . $image->getClientOriginalExtension();
      $image->move(public_path('assets/images'), $imageName);
      $banner->image = $imageName;
    }

    $banner->save();
    return redirect()->route('banners-list')->with('message', 'Banner added successfully');
  }

  // Update Banner
  public function editBanner($id)
  {
    $banner = Banner::find($id);
    $existingImage = explode(",", $banner->image);
    return view('content.apps.banners-edit', compact('banner', 'existingImage'));
  }


  public function updateBanner($id, Request $request)
  {
    $rules = [
      'banners_name' => 'required',
      'image' => 'required',
    ];

    $customMessages = [
      'banners_name.required' => 'Please enter banner name.',
    ];

    $this->validate($request, $rules, $customMessages);

    $banner = Banner::find($id);
    $banner->banners_name = $request->input('banners_name');

    if ($request->hasFile('image')) {
      $image = $request->file('image');
      $imageName = time() . '.' . $image->getClientOriginalExtension();
      $image->move(public_path('assets/images'), $imageName);
      $banner->image = $imageName;
    }

    $banner->save();
    return redirect()->route('banners-list')->with('message', 'Banner updated successfully');
  }

  public function deleteBanner($id)
  {
    $banner = Banner::find($id);

    if (!$banner) {
      return response()->json(['success' => false]);
    }

    $banner->delete();
    return response()->json(['success' => true]);
  }
}
