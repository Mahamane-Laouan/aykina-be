<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Category;
use Illuminate\Http\Request;

class SliderListController extends Controller
{
    // index
    public function index(Request $request)
    {
        // Fetch slides ordered by creation date, paginated
        $records = Banner::orderBy('created_at', 'desc')
            ->paginate(10); // Paginate results

        return view('slider-list', compact('records'));
    }


    // addSlider
    public function addSlider()
    {
        $categories = Category::all();
        return view(
            'slider-add',
            compact('categories')
        );
        // return view('slider-add');
    }


    // saveSlider
    public function saveSlider(Request $request)
    {
        $rules = [
            'banner_image' => 'required',
        ];

        $customMessages = [
            'banner_image.required' => 'Please select slider image.',
        ];

        $this->validate($request, $rules, $customMessages);

        $category = new Banner();
        $category->cat_id = $request->input('cat_id');
        $category->banner_name = $request->input('banner_name');

        if ($request->hasFile('banner_image')) {
            $image = $request->file('banner_image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/banner_images'), $imageName);
            $category->banner_image = $imageName;
        }

        $category->save();

        return redirect()
            ->route('slider-list')
            ->with('message', 'Slider added successfully');
    }


    // deleteSlider
    public function deleteSlider($id)
    {
        $data = Banner::where('id', $id)->delete();
        return response()->json(['message' => 'Slider deleted successfully']);
    }

    public function editSlider($id)
    {

        $subcategory = Banner::findOrFail($id);
        $existingImage = $subcategory->banner_image;
        $categories = Category::all();

        return view('slider-edit', [
            'subcategory' => $subcategory,
            'categories' => $categories,
            'existingImage' => $existingImage,

        ]);
    }


    // updateSubcategory
    public function updateSlider($id, Request $request)
    {

        $request->validate([
            'cat_id' => 'required',
            'c_name' => 'nullable',
        ]);


        $subcategory = Banner::find($id);
        $subcategory->cat_id = $request->input('cat_id');
        $subcategory->banner_name = $request->input('banner_name');
        // $subcategory->status = $request->input('status');

        // Handle category image upload
        if ($request->hasFile('banner_image')) {
            $oldImagePath = public_path('images/banner_images/' . $subcategory->banner_image);
            if ($subcategory->banner_image && file_exists($oldImagePath)) {
                unlink($oldImagePath);
            }

            $image = $request->file('banner_image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/banner_images'), $imageName);
            $subcategory->banner_image = $imageName;
        }


        $subcategory->save();
        return redirect()->route('slider-list')->with('message', 'Slider updated successfully');
    }

}
