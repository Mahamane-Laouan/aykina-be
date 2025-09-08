<?php

namespace App\Http\Controllers\apps;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class CategoryController extends Controller
{

  public function index()
  {
    $categories = Category::all();
    return view('content.apps.categories-list', compact('categories'));
  }


  // Datatables
  public function getCategoryData(Request $request)
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
    $totalRecords = Category::select('count(*) as allcount')->count();
    $totalRecordswithFilter = Category::select('count(*) as allcount')->where('c_name', 'like', '%' . $searchValue . '%')->count();

    $records = DB::table('categories')
      ->select(DB::raw('categories.id, categories.c_name, categories.description, categories.is_features, categories.status, categories.img, COUNT(services.id) as total_res'))
      ->leftJoin('services', 'categories.id', '=', 'services.cat_id')
      ->groupBy('categories.id', 'categories.c_name', 'categories.description', 'categories.is_features', 'categories.status', 'categories.img')
      ->orderBy($columnName, $columnSortOrder)
      ->where(function ($query) use ($searchValue) {
        $query->where('categories.c_name', 'like', '%' . $searchValue . '%');
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
        "total_res" => $record->total_res,
        "is_features" => $record->is_features,
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


  // Add category
  public function addCategory()
  {
    return view('content.apps.categories-add');
  }

  public function saveCategory(Request $request)
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

    $category = new Category;
    $category->c_name = $request->input('c_name');
    $category->description = $request->input('description');
    $category->is_features = $request->input('is_features');
    $category->status = $request->input('status');

    if ($request->hasFile('img')) {
      $image = $request->file('img');
      $imageName = time() . '.' . $image->getClientOriginalExtension();
      $image->move(public_path('assets/images/category'), $imageName);
      $category->img = $imageName;
    }

    $category->save();
    return redirect()->route('categories-list')->with('message', 'Category added successfully');
  }


  // Update Category
  public function editCategory($id)
  {
    $category = Category::find($id);
    $existingImage = explode(",", $category->img);
    return view('content.apps.categories-edit', compact('category', 'existingImage'));
  }

  public function updateCategory($id, Request $request)
  {

    $category = Category::find($id);
    $category->c_name = $request->input('c_name');
    $category->description = $request->input('description');
    $category->is_features = $request->input('is_features');
    $category->status = $request->input('status');

    if ($request->hasFile('img')) {
      $image = $request->file('img');
      $imageName = time() . '.' . $image->getClientOriginalExtension();
      $image->move(public_path('assets/images/category'), $imageName);
      $category->img = $imageName;
    }

    $category->save();
    return redirect()->route('categories-list')->with('message', 'Category updated successfully');;
  }

  // Delete Category
  public function deleteCategory($id)
  {
    Category::find($id)->delete();
    return response()->json(['message' => 'Category deleted successfully', 'id' => $id]);
  }


  // ChangeCategoryFeature
  public function ChangeCategoryFeature($id, Request $request)
  {
    if ($request->status == 1) {
      $status = 0;
      $data = Category::where('id', $id)->update(['is_features' => $status]);
      return response()->json(['message' => 'Status changed successfully', 'data' => $data]);
    } else {
      $status = 1;
      $data = Category::where('id', $id)->update(['is_features' => $status]);
      return response()->json(['message' => 'Status changed successfully', 'data' => $data]);
    }
  }


  // ChangeCategoryStatus
  public function ChangeCategoryStatus($id, Request $request)
  {
    if ($request->status == 1) {
      $status = 0;
      $data = Category::where('id', $id)->update(['status' => $status]);
      return response()->json(['message' => 'Status changed successfully', 'data' => $data]);
    } else {
      $status = 1;
      $data = Category::where('id', $id)->update(['status' => $status]);
      return response()->json(['message' => 'Status changed successfully', 'data' => $data]);
    }
  }
}
