<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PrivacyPolicy;

class PrivacyPolicyController extends Controller
{
    // index
    public function index()
    {
        $policy = PrivacyPolicy::first();
        return view('privacy-policy', compact('policy'));
    }


    // savePrivacyPolicy
    public function savePrivacyPolicy(Request $request)
    {

        $policy = PrivacyPolicy::first() ?? new PrivacyPolicy();
        $policy->text = $request->input('text');
        $policy->save();

        return redirect()->route('privacy-policy')->with('message', 'Privacy Policy updated successfully');
    }

    public function showPrivacyPolicy()
    {
        $privacyPolicy = PrivacyPolicy::first();
        return view('pages.policy', ['policy' => $privacyPolicy]);
    }
}
