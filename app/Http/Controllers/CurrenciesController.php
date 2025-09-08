<?php

namespace App\Http\Controllers;

use App\Models\Currencies;
use Illuminate\Http\Request;

class CurrenciesController extends Controller
{
    // index
    public function index(Request $request)
    {
        $search = $request->input('search');

        $records = Currencies::when($search, function ($query, $search) {
            return $query->where('c_name', 'LIKE', "%{$search}%");
        })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        if ($request->ajax()) {
            $recordsArray = $records->map(function ($record) {
                return [
                    'id' => $record->id,
                    'c_name' => $record->c_name,
                    'img' => $record->img ? asset('images/category_images/' . $record->img) : null,
                    'status' => $record->status,
                    'edit_url' => route('category-edit', $record->id),
                ];
            });

            return response()->json(['records' => $recordsArray]);
        }

        return view('currencies-list', compact('records', 'search'));
    }


    // addCurrencies
    public function addCurrencies()
    {
        return view('currencies-add');
    }


    // saveCurrencies
    public function saveCurrencies(Request $request)
    {
        $rules = [
            'currency' => 'required',
            'name' => 'required',
        ];

        $customMessages = [
            'name.required' => 'Please enter currency name.',
            'currency.required' => 'Please enter currency.',
        ];

        $this->validate($request, $rules, $customMessages);

        $category = new Currencies();
        $category->name = $request->input('name');
        $category->currency = $request->input('currency');

        $category->save();

        return redirect()->route('currencies-list')->with('message', 'Currency added successfully');
    }


    // deleteCurrencies
    public function deleteCurrencies($id)
    {
        $data = Currencies::where('id', $id)->delete();
        return response()->json(['message' => 'Currency deleted successfully']);
    }
}
