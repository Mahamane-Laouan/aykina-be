<?php

namespace App\Http\Controllers\apps;

use App\Http\Controllers\Controller;
use App\Models\Firebase;
use Illuminate\Http\Request;

class FirebaseController extends Controller
{

  // Add Firebase
  public function index()
  {
    $firebase = Firebase::all();
    return view('content.apps.firebase', compact('firebase'));
  }

  public function firebaseSave(Request $request)
  {
    $rules = [
      'firebase_key' => 'required',
    ];

    $customMessages = [
      'firebase_key.required' => 'Please enter firebase key.',
    ];

    $this->validate($request, $rules, $customMessages);

    $firebase = new Firebase;
    $firebase->firebase_key = $request->input('firebase_key');

    $firebase->save();
    return redirect()->route('firebase')->with('message', 'Firebase Key added successfully');
  }
}
