<?php

namespace App\Http\Controllers\apps;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\Slider;
use Illuminate\Http\Request;

class SliderController extends Controller
{
  public function index()
  {
    $sliders = Slider::all();
    return view('content.apps.sliders-list', compact('sliders'));
  }


  // Datatables
  public function getSliderData(Request $request)
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
    $totalRecords = Slider::select('count(*) as allcount')->count();
    $totalRecordswithFilter = Slider::select('count(*) as allcount')->where('slider_name', 'like', '%' . $searchValue . '%')->count();

    $records = Slider::orderBy($columnName, $columnSortOrder)
      ->where(function ($query) use ($searchValue) {
        $query->where('slider_name', 'like', '%' . $searchValue . '%');
      })
      ->skip($start)
      ->take($rowperpage)
      ->get();

    $data_arr = array();
    foreach ($records as $record) {
      $servicename = Service::where('id', $record->service_id)->value('service_name');
      $data_arr[] = array(
        "id" => $record->id,
        "slider_name" => $record->slider_name,
        "slider_description" => $record->slider_description,
        "slider_image" => $record->slider_image,
        "service_id" => $servicename,
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


  // Add slider
  public function addSlider()
  {
    $services = Service::all();
    return view('content.apps.sliders-add', compact('services'));
  }

  public function saveSlider(Request $request)
  {
    $rules = [
      'slider_name' => 'required',
      'slider_description' => 'required',
      'slider_image' => 'required',
      'status' => 'required',
    ];

    $customMessages = [
      'slider_name.required' => 'Please enter slider name.',
      'slider_description.required' => 'Please enter slider description.',
    ];

    $this->validate($request, $rules, $customMessages);

    $slider = new Slider();
    $slider->slider_name = $request->input('slider_name');
    $slider->slider_description = $request->input('slider_description');
    $slider->status = $request->input('status');
    $slider->service_id = $request->input('service_id', auth()->id());

    if ($request->hasFile('slider_image')) {
      $image = $request->file('slider_image');
      $imageName = time() . '.' . $image->getClientOriginalExtension();
      $image->move(public_path('assets/images/slider'), $imageName);
      $slider->slider_image = $imageName;
    }

    $slider->save();
    return redirect()->route('sliders-list')->with('message', 'Slider added successfully');
  }

  // Delete Slider
  public function deleteSlider($id)
  {
    Slider::find($id)->delete();
    return response()->json(['message' => 'Slider deleted successfully', 'id' => $id]);
  }

  // ChangeSliderStatus
  public function ChangeSliderStatus($id, Request $request)
  {
    if ($request->status == 1) {
      $status = 0;
      $data = Slider::where('id', $id)->update(['status' => $status]);
      return response()->json(['message' => 'Status changed successfully', 'data' => $data]);
    } else {
      $status = 1;
      $data = Slider::where('id', $id)->update(['status' => $status]);
      return response()->json(['message' => 'Status changed successfully', 'data' => $data]);
    }
  }
}
