<?php

namespace App\Http\Controllers;

use App\Models\About;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    // index
    public function index()
    {
        $policy = About::first();
        return view('about', compact('policy'));
    }


    // saveAbout
    public function saveAbout(Request $request)
    {

        $policy = About::first() ?? new About();
        $policy->text = $request->input('text');
        $policy->save();

        return redirect()->route('about')->with('message', 'About updated successfully');
    }
}
