<?php

namespace App\Http\Controllers\apps;

use App\Http\Controllers\Controller;
use App\Models\TaxRate;
use Illuminate\Http\Request;

class TaxRateController extends Controller
{
  public function index()
  {
    $taxrate = TaxRate::all();
    return view('content.apps.taxrate-list', compact('taxrate'));
  }

  // Datatables
  public function getTaxrateData(Request $request)
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
    $totalRecords = TaxRate::select('count(*) as allcount')->count();
    $totalRecordswithFilter = TaxRate::select('count(*) as allcount')->where('name', 'like', '%' . $searchValue . '%')->count();
    $records = TaxRate::orderBy($columnName, $columnSortOrder)
      ->where(function ($query) use ($searchValue) {
        $query->where('name', 'like', '%' . $searchValue . '%');
      })
      ->skip($start)
      ->take($rowperpage)
      ->get();

    $data_arr = array();
    foreach ($records as $record) {
      $data_arr[] = array(
        "id" => $record->id,
        "name" => $record->name,
        "tax_rate" => $record->tax_rate,
        "status" => $record->status,
        "type" => $record->type,
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


  //  addTaxrate
  public function addTaxrate(Request $request)
  {
    return view('content.apps.taxrate-add');
  }


  public function saveTaxrate(Request $request)
  {
    $rules = [
      'name' => 'required',
      'tax_rate' => 'required',
      'type' => 'required',
      'status' => 'required',
    ];

    $customMessages = [
      'name.required' => 'Please enter title.',
      'tax_rate.required' => 'Please enter tax rate.',
      'status.required' => 'Please select status.',
      'type.required' => 'Please select type.',
    ];

    $this->validate($request, $rules, $customMessages);

    $data = new TaxRate();
    $data->name = $request->name;
    $data->tax_rate = $request->tax_rate;
    $data->type = $request->type;
    $data->status = $request->status ? 1 : 0;
    $data->save();

    return redirect()->route('taxrate-list')->with('message', 'Tax added successfully');
  }


  //  editTaxrate
  public function editTaxrate($id)
  {
    $taxRate = TaxRate::find($id);
    return view('content.apps.taxrate-edit', compact('taxRate'));
  }


  public function updateTaxrate(Request $request, $id)
  {

    $data = TaxRate::find($id);
    $data->name = $request->name;
    $data->tax_rate = $request->tax_rate;
    $data->type = $request->type;
    $data->status = $request->status ? 1 : 0;
    $data->save();

    return redirect()->route('taxrate-list')->with('message', 'Tax updated successfully');
  }

  // ChangeTaxrateStatus
  public function ChangeTaxrateStatus($id, Request $request)
  {
    if ($request->status == 1) {
      $status = 0;
      $data = TaxRate::where('id', $id)->update(['status' => $status]);
      return response()->json(['message' => 'Status changed successfully', 'data' => $data]);
    } else {
      $status = 1;
      $data = TaxRate::where('id', $id)->update(['status' => $status]);
      return response()->json(['message' => 'Status changed successfully', 'data' => $data]);
    }
  }

  //  Delete TaxRate
  public function deleteTaxrate($id)
  {
    $data = TaxRate::find($id)->delete();
    return response()->json(['message' => 'Tax deleted successfully', 'id' => $id]);
  }
}
