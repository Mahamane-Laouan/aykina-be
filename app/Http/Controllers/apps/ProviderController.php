<?php

namespace App\Http\Controllers\apps;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ProviderController extends Controller
{
  public function index()
  {
    $users = User::all();
    return view('content.apps.providers-list', compact('users'));
  }


  // Datatables
  public function getProviderData(Request $request)
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
    $totalRecords = User::where('user_role', 'Provider')->count();
    $totalRecordswithFilter = User::where('user_role', 'Provider')
      ->where('firstname', 'like', '%' . $searchValue . '%')
      ->count();

    $records = User::orderBy($columnName, $columnSortOrder)
      ->where('user_role', 'Provider')
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


  // Add Provider
  public function addProvider()
  {
    return view('content.apps.providers-add');
  }

  // Save Provider
  public function saveProvider(Request $request)
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


  // Edit Provider
  public function editProvider($id)
  {
    $user = User::find($id);
    $existingImage = explode(",", $user->profile_pic);
    return view('content.apps.providers-edit', compact('user', 'existingImage'));
  }

  // Update Provider
  public function updateProvider($id, Request $request)
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

    return redirect()->route('providers-list')->with('message', 'Provider updated successfully');;
  }

  // Delete Provider
  public function deleteProvider($id)
  {
    User::find($id)->delete();
    return response()->json(['message' => 'Provider deleted successfully', 'id' => $id]);
  }






  // Provider Request
  public function ProviderRequest()
  {
    $users = User::all();
    return view('content.apps.providers-requestlist', compact('users'));
  }


  // Provider Request Datatables
  public function getProviderRequestData(Request $request)
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
    $totalRecords = User::where('user_role', 'Provider')->count();
    $totalRecordswithFilter = User::where('user_role', 'Provider')
      ->where('firstname', 'like', '%' . $searchValue . '%')
      ->count();

    $records = User::orderBy($columnName, $columnSortOrder)
      ->where('user_role', 'Provider')
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
        "confirmation" => $record->confirmation,
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


  // Edit RequestProvider
  public function editRequestProvider($id)
  {
    $user = User::find($id);
    return view('content.apps.providers-requestlist', compact('user'));
  }

  // Update RequestProvider
  public function updateRequestProvider($id, Request $request)
  {
    $user = User::find($id);
    $user->confirmation = $request->input('confirmation');

    if ($user->save()) {
      return response()->json(['success' => true]);
    } else {
      return response()->json(['success' => false]);
    }
  }
}
