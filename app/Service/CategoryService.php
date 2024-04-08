<?php

namespace App\Service;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryService
{
    public function storeCategory(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:categories',
            'status' => 'required|boolean',
            'vehicle' => 'required|array',
            'vehicle.*' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Max size in KB (2MB)
        ]);

        $imageName = $this->uploadImage($request->file('image'));

        $category = Category::create([
            'name' => $validatedData['name'],
            'slug' => $validatedData['slug'],
            'status' => $validatedData['status'],
            'image' => $imageName,
            'vehicle' => implode(',', $validatedData['vehicle'])
        ]);


        $request->session()->flash('success', 'Category Created Successfully');
        return $category;
    }

    private function uploadImage($image)
    {
        $imageName = time() . '_' . $image->getClientOriginalName();
        $destinationPath = public_path('new_image');
        $image->move($destinationPath, $imageName);
        return $imageName;
    }

    public function updateCategory(Request $request, $categoryId)
    {
        $category = Category::findOrFail($categoryId);
        $imageName = $request->hasFile('image') ? $this->imageUpdate($request->file('image')) : $category->image;
        $category->name = $request->name;
        $category->slug = $request->slug;
        $category->status = $request->status;
        $category->image = $imageName;
        $vehicles = is_array($request->vehicle) ? $request->vehicle : [$request->vehicle];
        $category->vehicle = implode(',', $vehicles);
        $category->save();

        return $category; // Return the updated category model
    }


    private function imageUpdate($image)
    {
        $imageName = time() . '_' . $image->getClientOriginalName();
        $destinationPath = public_path('new_image');
        $image->move($destinationPath, $imageName);
        return $imageName;
    }
}
