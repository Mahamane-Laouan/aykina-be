<?php

namespace App\Http\Controllers;

use App\Models\CancelPolicy;
use Illuminate\Http\Request;

class CancelPolicyController extends Controller
{
    // index
    public function index()
    {
        $policy = CancelPolicy::first();
        return view('cancel-policy', compact('policy'));
    }



    // saveCancelPolicy
    public function saveCancelPolicy(Request $request)
    {

        $policy = CancelPolicy::first() ?? new CancelPolicy();
        $policy->text = $request->input('text');
        $policy->save();

        return redirect()->route('cancel-policy')->with('message', 'Cancel Policy updated successfully');
    }


    // showCancelPolicy
    public function showCancelPolicy()
    {
        $privacyPolicy = CancelPolicy::first();
        return view('pages.policy', ['policy' => $privacyPolicy]);
    }
}
