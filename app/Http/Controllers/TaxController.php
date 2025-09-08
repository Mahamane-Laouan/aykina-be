<?php

namespace App\Http\Controllers;

use App\Models\TaxRate;
use Illuminate\Http\Request;

class TaxController extends Controller
{
    // index
    public function index(Request $request)
    {
        $search = $request->input('search');

        $records = TaxRate::when($search, function ($query, $search) {
            return $query->where('name', 'LIKE', "%{$search}%");
        })
            ->orderBy('created_at', 'desc')
            ->paginate(10);


        return view('tax-list', compact('records', 'search'));
    }


    // addTax
    public function addTax()
    {
        return view('tax-add');
    }


    // saveTax
    public function saveTax(Request $request)
    {
        $rules = [
            'name' => 'required',
            'tax_rate' => 'required',
            'type' => 'required',
            'status' => 'required',
        ];

        $customMessages = [
            'name.required' => 'Please enter tax name.',
            'tax_rate.required' => 'Please eneter tax rate.',
            'type.required' => 'Please select tax type.',
            'status.required' => 'Please select status.',
        ];

        $this->validate($request, $rules, $customMessages);

        $category = new TaxRate();
        $category->name = $request->input('name');
        $category->tax_rate = $request->input('tax_rate');
        $category->type = $request->input('type');
        $category->status = $request->input('status');

        $category->save();

        return redirect()->route('tax-list')->with('message', 'Tax added successfully');
    }




    // editTax
    public function editTax($id)
    {
        $category = TaxRate::findOrFail($id);

        return view('tax-edit', [
            'category' => $category,
        ]);
    }


    // updateTax
    public function updateTax($id, Request $request)
    {
        $category = TaxRate::find($id);
        $category->name = $request->input('name');
        $category->tax_rate = $request->input('tax_rate');
        $category->type = $request->input('type');
        $category->status = $request->input('status');


        $category->save();
        return redirect()->route('tax-list')->with('message', 'Tax updated successfully');
    }



    // deleteTax
    public function deleteTax($id)
    {
        $data = TaxRate::where('id', $id)->delete();
        return response()->json(['message' => 'Tax deleted successfully']);
    }


    // changeTaxStatus 
    public function
    changeTaxStatus($id)
    {
        // Check the current status
        $currentType = TaxRate::where('id', $id)->value('status');

        // Toggle the status (1 -> 0, 0 -> 1)
        $status = $currentType == 1 ? 0 : 1;

        // Update the status
        $updated = TaxRate::where('id', $id)->update(['status' => $status]);

        if ($updated) {
            return response()->json(['message' => 'Status changed successfully']);
        } else {
            return response()->json(['message' => 'Failed to change status'], 500);
        }
    }

    public function toggleUserType(Request $request)
    {
        // Get the 'user_id' from the request
        $id = $request->input('id'); // Ensure 'id' is coming from the frontend correctly

        if (!$id) {
            return response()->json(['message' => 'Invalid ID'], 400);
        }

        // Check current status
        $currentType = TaxRate::where('id', $id)->value('type');

        if ($currentType === null) {
            return response()->json(['message' => 'Record not found'], 404);
        }

        // Toggle status
        $status = $currentType == 1 ? 0 : 1;

        // Update status
        $updated = TaxRate::where('id', $id)->update(['type' => $status]);

        if ($updated) {
            return response()->json([
                'success' => true, // Add success key to return true on success
                'message' => 'Status changed successfully',
                'new_status' => $status
            ]);
        } else {
            return response()->json(['message' => 'Failed to change status'], 500);
        }
    }
}
