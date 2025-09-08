<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // index
    public function index(Request $request)
    {
        $search = $request->input('search');

        $records = Category::when($search, function ($query, $search) {
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

        return view('category-list', compact('records', 'search'));
    }

    // addCategory
    public function addCategory()
    {
        return view('category-add');
    }

    // saveCategory
    public function saveCategory(Request $request)
    {
        $rules = [
            'c_name' => 'required',
            'img' => 'required',
            'status' => 'required',
        ];

        $customMessages = [
            'c_name.required' => 'Please enter category name.',
            'img.required' => 'Please select category image.',
            'status.required' => 'Please select status.',
        ];

        $this->validate($request, $rules, $customMessages);

        $category = new Category();
        $category->c_name = $request->input('c_name');
        $category->status = $request->input('status');

        if ($request->hasFile('img')) {
            $image = $request->file('img');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/category_images'), $imageName);
            $category->img = $imageName;
        }

        $category->save();

        return redirect()->route('category-list')->with('message', 'Category added successfully');
    }

    // editCategory
    public function editCategory($id)
    {
        $category = Category::findOrFail($id);
        $existingImage = $category->img;

        return view('category-edit', [
            'category' => $category,
            'existingImage' => $existingImage,
        ]);
    }

    // updateCategory
    public function updateCategory($id, Request $request)
    {
        $category = Category::find($id);
        $category->c_name = $request->input('c_name');
        $category->status = $request->input('status');

        // Handle category image upload
        if ($request->hasFile('img')) {
            $oldImagePath = public_path('images/category_images/' . $category->img);
            if ($category->img && file_exists($oldImagePath)) {
                unlink($oldImagePath);
            }

            $image = $request->file('img');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/category_images'), $imageName);
            $category->img = $imageName;
        }

        $category->save();
        return redirect()->route('category-list')->with('message', 'Category updated successfully');
    }

    // deleteCategory
    public function deleteCategory($id)
    {
        $data = Category::where('id', $id)->delete();
        return response()->json(['message' => 'Category deleted successfully']);
    }


    // changeCategoryStatus 
    public function
    changeCategoryStatus($id)
    {
        // Check the current status
        $currentType = Category::where('id', $id)->value('status');

        // Toggle the status (1 -> 0, 0 -> 1)
        $status = $currentType == 1 ? 0 : 1;

        // Update the status
        $updated = Category::where('id', $id)->update(['status' => $status]);

        if ($updated) {
            return response()->json(['message' => 'Status changed successfully']);
        } else {
            return response()->json(['message' => 'Failed to change status'], 500);
        }
    }
}
