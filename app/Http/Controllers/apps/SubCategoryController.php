<?php

namespace App\Http\Controllers\apps;

use App\Http\Controllers\Controller;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SubCategoryController extends Controller
{
  public function index()
  {
    $categories = SubCategory::all();
    return view('content.apps.subcategories-list', compact('categories'));
  }


  // Datatables
  public function getSubCategoryData(Request $request)
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
    $totalRecords = SubCategory::select('count(*) as allcount')->count();
    $totalRecordswithFilter = SubCategory::select('count(*) as allcount')->where('c_name', 'like', '%' . $searchValue . '%')->count();

    $records = DB::table('sub_categories')
      ->select(DB::raw('sub_categories.id, sub_categories.c_name, sub_categories.description, sub_categories.is_features, sub_categories.status, sub_categories.img, COUNT(services.id) as total_res'))
      ->leftJoin('services', 'sub_categories.id', '=', 'services.subc_id')
      ->groupBy('sub_categories.id', 'sub_categories.c_name', 'sub_categories.description', 'sub_categories.is_features', 'sub_categories.status', 'sub_categories.img')
      ->orderBy($columnName, $columnSortOrder)
      ->where(function ($query) use ($searchValue) {
        $query->where('sub_categories.c_name', 'like', '%' . $searchValue . '%');
      })
      ->skip($start)
      ->take($rowperpage)
      ->get();
    $data_arr = array();
    foreach ($records as $record) {
      $data_arr[] = array(
        "id" => $record->id,
        "c_name" => $record->c_name,
        "description" => $record->description,
        "is_features" => $record->is_features,
        "total_res" => $record->total_res,
        "status" => $record->status,
        "img" => $record->img,
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


  // Add Sub category
  public function addSubCategory()
  {
    return view('content.apps.subcategories-add');
  }

  public function saveSubCategory(Request $request)
  {
    $rules = [
      'c_name' => 'required',
      'description' => 'required',
    ];

    $customMessages = [
      'c_name.required' => 'Please enter category name.',
      'description.required' => 'Please enter description.',
    ];

    $this->validate($request, $rules, $customMessages);

    $category = new SubCategory();
    $category->c_name = $request->input('c_name');
    $category->description = $request->input('description');
    $category->is_features = $request->input('is_features');
    $category->status = $request->input('status');

    if ($request->hasFile('img')) {
      $image = $request->file('img');
      $imageName = time() . '.' . $image->getClientOriginalExtension();
      $image->move(public_path('assets/images/subcategory'), $imageName);
      $category->img = $imageName;
    }

    $category->save();
    return redirect()->route('subcategories-list')->with('message', 'Sub Category added successfully');
  }


  // Update Sub Category
  public function editSubCategory($id)
  {
    $category = SubCategory::find($id);
    $existingImage = explode(",", $category->img);
    return view('content.apps.subcategories-edit', compact('category', 'existingImage'));
  }

  public function updateSubCategory($id, Request $request)
  {

    $category = SubCategory::find($id);
    $category->c_name = $request->input('c_name');
    $category->description = $request->input('description');
    $category->is_features = $request->input('is_features');
    $category->status = $request->input('status');

    if ($request->hasFile('img')) {
      $image = $request->file('img');
      $imageName = time() . '.' . $image->getClientOriginalExtension();
      $image->move(public_path('assets/images/subcategory'), $imageName);
      $category->img = $imageName;
    }

    $category->save();
    return redirect()->route('subcategories-list')->with('message', 'Sub Category updated successfully');;
  }

  // Delete Sub Category
  public function deleteSubCategory($id)
  {
    SubCategory::find($id)->delete();
    return response()->json(['message' => 'Sub Category deleted successfully', 'id' => $id]);
  }


  // ChangeSubCategoryFeature
  public function ChangeSubCategoryFeature($id, Request $request)
  {
    if ($request->status == 1) {
      $status = 0;
      $data = SubCategory::where('id', $id)->update(['is_features' => $status]);
      return response()->json(['message' => 'Status changed successfully', 'data' => $data]);
    } else {
      $status = 1;
      $data = SubCategory::where('id', $id)->update(['is_features' => $status]);
      return response()->json(['message' => 'Status changed successfully', 'data' => $data]);
    }
  }


  // ChangeSubCategoryStatus
  public function ChangeSubCategoryStatus($id, Request $request)
  {
    if ($request->status == 1) {
      $status = 0;
      $data = SubCategory::where('id', $id)->update(['status' => $status]);
      return response()->json(['message' => 'Status changed successfully', 'data' => $data]);
    } else {
      $status = 1;
      $data = SubCategory::where('id', $id)->update(['status' => $status]);
      return response()->json(['message' => 'Status changed successfully', 'data' => $data]);
    }
  }
}
