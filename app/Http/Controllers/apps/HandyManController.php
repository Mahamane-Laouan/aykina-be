<?php

namespace App\Http\Controllers\apps;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HandyManController extends Controller
{
  public function index()
  {
    $users = User::all();
    return view('content.apps.handyman-list', compact('users'));
  }

  // Datatables
  public function getHandymanData(Request $request)
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
    $totalRecords = User::where('user_role', 'Handyman')->count();
    $totalRecordswithFilter = User::where('user_role', 'Handyman')
      ->where('firstname', 'like', '%' . $searchValue . '%')
      ->count();

    $records = User::orderBy($columnName, $columnSortOrder)
      ->where('user_role', 'Handyman')
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

  // Add Handyman
  public function addHandyman()
  {
    return view('content.apps.handyman-add');
  }


  // Save Handyman
  public function saveHandyman(Request $request)
  {
    $rules = [
      'firstname' => 'required',
      'lastname' => 'required',
      'mobile' => 'required',
      'email' => 'required|email',
      'password' => 'required|confirmed',
      'profile_image' => 'required|image',
      'user_role' => 'required',
      'is_online' => 'required|in:0,1',
    ];

    $customMessages = [
      'firstname.required' => 'Please enter first name.',
      'lastname.required' => 'Please enter last name.',
      'mobile.required' => 'Please enter contact number.',
      'email.required' => 'Please enter email.',
      'password.required' => 'Please enter password.',
      'password.confirmed' => 'Password confirmation does not match.',
      'profile_image.required' => 'Please upload a profile image.',
      'user_role.required' => 'Please select role.',
      'is_online.required' => 'Please select status.',
    ];

    $this->validate($request, $rules, $customMessages);

    $user = new User();
    $user->firstname = $request->input('firstname');
    $user->lastname = $request->input('lastname');
    $user->email = $request->input('email');
    $user->mobile = $request->input('mobile');
    $user->password = bcrypt($request->input('password'));
    $user->user_role = $request->input('user_role');
    $user->is_online = $request->input('is_online');

    if ($request->hasFile('profile_image')) {
      $image = $request->file('profile_image');
      $imageName = time() . '.' . $image->getClientOriginalExtension();
      $image->move(public_path('assets/images/user/'), $imageName);
      $user->profile_pic = $imageName;
    }

    $user->save();

    // Determine the appropriate message based on user_role
    $redirectRoute = ($user->user_role == 'provider') ? 'providers-list' : 'handyman-list';
    $message = ($user->user_role == 'provider') ? 'Provider' : 'Handyman';
    $message .= ' added successfully';

    return redirect()->route($redirectRoute)->with('message', $message);
  }


  // Edit Handyman
  public function editHandyman($id)
  {
    $user = User::find($id);
    $existingImage = explode(",", $user->profile_pic);
    return view('content.apps.handyman-edit', compact('user', 'existingImage'));
  }


  //  Update Handyman
  public function updateHandyman($id, Request $request)
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

    return redirect()->route('handyman-list')->with('message', 'Handyman updated successfully');;
  }

  // Delete Handyman
  public function deleteHandyman($id)
  {
    User::find($id)->delete();
    return response()->json(['message' => 'Handyman deleted successfully', 'id' => $id]);
  }
}
