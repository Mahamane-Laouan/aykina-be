<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    // index
    public function index()
    {
        $user = Auth::guard('admin')->user(); // Get the currently authenticated user

        // Return view with the user data
        return view('profile', compact('user'));
    }


    // saveProfile
    public function saveProfile(Request $request)
    {
        $user = Auth::guard('admin')->user(); // Get the currently authenticated user

        // Update the user's details
        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->email = $request->email;
        $user->mobile = $request->mobile;

        // Check if there's a profile picture and upload it
        if ($request->hasFile('profile_pic')) {
            $profile_pic = $request->file('profile_pic');
            $imageName = time() . '_image_' . uniqid() . '.' . $profile_pic->getClientOriginalExtension();
            $profile_pic->move(public_path('images/user'), $imageName);
            $user->profile_pic = $imageName;
        }

        // Save the user's data
        $user->save();

        return redirect()->route('profile')->with('message', 'Account Profile updated successfully');
    }


    // savePassword
    public function savePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ]);

        $user = Auth::guard('admin')->user(); // Get the currently authenticated user



        // Check if current password matches for the logged-in user or admin
        if (!$user || !Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->withErrors(['current_password' => 'Current password is incorrect']);
        }

        // Update the password and save
        $user->password = Hash::make($request->new_password);
        $user->save();

        // Return a message after updating the password
        return redirect()->route('profile')->with('message', 'Password changed successfully');
    }
}
