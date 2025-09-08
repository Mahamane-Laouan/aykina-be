<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class SubCategoryListController extends Controller
{
    // index
    public function index(Request $request)
    {
        $search = $request->input('search');

        $records = SubCategory::with('category') // Eager load the category relationship
        ->when($search, function ($query, $search) {
            $query->where(function ($q) use ($search) {
                $q->where('c_name', 'like', "%{$search}%") // Search in subcategory name
                ->orWhereHas('category', function ($q) use ($search) {
                    $q->where('c_name', 'like', "%{$search}%"); // Search in category name
                });
            });
        })
            ->orderBy('created_at', 'desc') // Order by created_at, latest first
            ->paginate(10); // Paginate results

        if ($request->ajax()) {
            $recordsArray = $records->map(function ($record) {
                return [
                    'id' => $record->id,
                    'c_name' => $record->c_name ?? '',
                    'img' => $record->img ? asset('images/subcategory_icon/' . $record->img) : null,
                    'category_name' => $record->category->c_name ?? '',
                    'category_url' => $record->category && $record->category->id
                        ? route('category-edit', $record->category->id)
                        : null,
                    'status' => $record->status,
                    'edit_url' => route('subcategory-edit', $record->id),
                ];
            });

            return response()->json(['records' => $recordsArray]);
        }

        return view('subcategory-list', compact('records', 'search'));
    }



    // addSubcategory
    public function addSubcategory()
    {
        $categories = Category::all();
        return view(
            'subcategory-add',
            compact('categories')
        );
    }


    // saveSubcategory
    public function saveSubcategory(Request $request)
    {
        $rules = [
            'cat_id' => 'required',
            'c_name' => 'required',
            'status' => 'required',
        ];

        $customMessages = [
            'cat_id.required' => 'Please select a category.',
            'c_name.required' => 'Please enter a subcategory name.',
            'status.required' => 'Please select status.',
        ];

        $this->validate(
            $request,
            $rules,
            $customMessages
        );

        $subcategory = new SubCategory();
        $subcategory->cat_id = $request->input('cat_id');
        $subcategory->c_name = $request->input('c_name');
        $subcategory->status = $request->input('status');

        if ($request->hasFile('img')) {
            $image = $request->file('img');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/subcategory_icon'), $imageName);
            $subcategory->img = $imageName;
        }

        $subcategory->save();

        return redirect()->route('subcategory-list')->with('message', 'Sub Category added successfully');
    }


    // editSubcategory
    public function editSubcategory($id)
    {

        $subcategory = SubCategory::findOrFail($id);
        $existingImage = $subcategory->img;
        $categories = Category::all();

        return view('subcategory-edit', [
            'subcategory' => $subcategory,
            'categories' => $categories,
            'existingImage' => $existingImage,

        ]);
    }


    // updateSubcategory
    public function updateSubcategory($id, Request $request)
    {

        $request->validate([
            'cat_id' => 'required',
            'c_name' => 'nullable',
        ]);


        $subcategory = SubCategory::find($id);
        $subcategory->cat_id = $request->input('cat_id');
        $subcategory->c_name = $request->input('c_name');
        $subcategory->status = $request->input('status');

        // Handle category image upload
        if ($request->hasFile('img')) {
            $oldImagePath = public_path('images/subcategory_icon/' . $subcategory->img);
            if ($subcategory->img && file_exists($oldImagePath)) {
                unlink($oldImagePath);
            }

            $image = $request->file('img');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/subcategory_icon'), $imageName);
            $subcategory->img = $imageName;
        }


        $subcategory->save();
        return redirect()->route('subcategory-list')->with('message', 'Sub Category updated successfully');
    }


    // deleteSubcategory
    public function deleteSubcategory($id)
    {
        $data = SubCategory::where('id', $id)->delete();
        return response()->json(['message' => 'Sub Category deleted successfully']);
    }


    // changeSubCategoryStatus 
    public function
    changeSubCategoryStatus($id)
    {
        // Check the current status
        $currentType = SubCategory::where('id', $id)->value('status');

        // Toggle the status (1 -> 0, 0 -> 1)
        $status = $currentType == 1 ? 0 : 1;

        // Update the status
        $updated = SubCategory::where('id', $id)->update(['status' => $status]);

        if ($updated) {
            return response()->json(['message' => 'Status changed successfully']);
        } else {
            return response()->json(['message' => 'Failed to change status'], 500);
        }
    }
}
