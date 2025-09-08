<?php

namespace App\Http\Controllers;

use App\Models\Commissions;
use Illuminate\Http\Request;

class HandymanCommissionController extends Controller
{
    // index
    public function index()
    {
        // Fetch the data where people_id = 2
        $data = Commissions::where('people_id', 2)->first();

        return view('handyman-commission', compact('data'));
    }


    // saveHandymanCommission
    public function saveHandymanCommission(Request $request)
    {

        $data = Commissions::where('people_id', 2)->first() ?? new Commissions();

        $data->value = $request->value;
        $data->save();

        return redirect()->route('handyman-commission')->with('message', 'Handyman Commission updated successfully');
    }
}
