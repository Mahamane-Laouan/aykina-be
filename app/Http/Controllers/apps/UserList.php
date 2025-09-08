<?php

namespace App\Http\Controllers\apps;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserList extends Controller
{
  public function index()
  {
    $users = User::all();
    return view('content.apps.users-list', compact('users'));
  }


  // Datatables
  public function getUsersData(Request $request)
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
    $totalRecords = User::where('user_role', 'User')->count();
    $totalRecordswithFilter = User::where('user_role', 'User')
      ->where('firstname', 'like', '%' . $searchValue . '%')
      ->count();

    $records = User::orderBy($columnName, $columnSortOrder)
      ->where('user_role', 'User')
      ->where(function ($query) use ($searchValue) {
        $query->where('firstname', 'like', '%' . $searchValue . '%');
      })
      ->skip($start)
      ->take($rowperpage)
      ->get();

    $data_arr = array();
    foreach ($records as $record) {
      $createdAt = Carbon::parse($record->created_at)->format('d M, Y / g:i A');

      $phoneNumber = $record->country_code . ' ' . $record->mobile;

      $data_arr[] = array(
        "id" => $record->id,
        "firstname" => $record->firstname . ' ' . $record->lastname,
        "email" => $record->email,
        "profile_pic" => $record->profile_pic,
        "user_role" => $record->user_role,
        "mobile" => $phoneNumber,
        "is_online" => $record->is_online,
        "created_at" => $createdAt,
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

  // Edit User
  public function editUser($id)
  {
    $user = User::find($id);
    $existingImage = explode(",", $user->profile_pic);
    return view('content.apps.users-edit', compact('user', 'existingImage'));
  }

  //  Update User
  public function updateUser($id, Request $request)
  {
    $user = User::find($id);
    $user->firstname = $request->input('firstname');
    $user->lastname = $request->input('lastname');
    $user->email = $request->input('email');
    $user->mobile = $request->input('mobile');
    $user->is_online = $request->input('is_online');

    if ($request->hasFile('profile_image')) {
      $image = $request->file('profile_image');
      $imageName = time() . '.' . $image->getClientOriginalExtension();
      $image->move(public_path('assets/images/user/'), $imageName);
      $user->profile_pic = $imageName;
    }

    $user->save();

    return redirect()->route('users-list')->with('message', 'User updated successfully');;
  }

  // Delete User
  public function deleteUser($id)
  {
    User::find($id)->delete();
    return response()->json(['message' => 'User deleted successfully', 'id' => $id]);
  }
}
