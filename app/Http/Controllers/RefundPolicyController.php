<?php

namespace App\Http\Controllers;

use App\Models\RefundPolicy;
use Illuminate\Http\Request;

class RefundPolicyController extends Controller
{
    // index
    public function index()
    {
        $policy = RefundPolicy::first();
        return view('refund-policy', compact('policy'));
    }



    // saveRefundPolicy
    public function saveRefundPolicy(Request $request)
    {

        $policy = RefundPolicy::first() ?? new RefundPolicy();
        $policy->text = $request->input('text');
        $policy->save();

        return redirect()->route('refund-policy')->with('message', 'Refund Policy updated successfully');
    }


    // showRefundPolicy
    public function showRefundPolicy()
    {
        $privacyPolicy = RefundPolicy::first();
        return view('pages.policy', ['policy' => $privacyPolicy]);
    }
}
