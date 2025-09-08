<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TermsCondition;


class TermsConditionController extends Controller
{
    // index
    public function index()
    {
        $term = TermsCondition::first();
        return view('terms-conditions', compact('term'));
    }


    // saveTermsCondition
    public function saveTermsCondition(Request $request)
    {

        $term = TermsCondition::first() ?? new TermsCondition();
        $term->text = $request->input('text');
        $term->save();

        return redirect()->route('terms-conditions')->with('message', 'Terms & Condition updated successfully');
    }
}
