<?php

namespace App\Http\Controllers;

use App\Models\ContactUs;
use Illuminate\Http\Request;

class ContactUsController extends Controller
{
    // index
    public function index()
    {
        $policy = ContactUs::first();
        return view('contact-us', compact('policy'));
    }



    // saveContactUs
    public function saveContactUs(Request $request)
    {

        $policy = ContactUs::first() ?? new ContactUs();
        $policy->text = $request->input('text');
        $policy->save();

        return redirect()->route('contactus')->with('message', 'Contact Us updated successfully');
    }

    public function showContactus()
    {
        $privacyPolicy = ContactUs::first();
        return view('pages.policy', ['policy' => $privacyPolicy]);
    }
}
