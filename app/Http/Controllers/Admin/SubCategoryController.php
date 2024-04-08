<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SubCategoryController extends Controller
{
    public function index(Request $request)
    {
        $subcategories = SubCategory::select('sub_categories.*', 'categories.name as categoryName')
            ->latest('sub_categories.id')->leftJoin('categories', 'categories.id', 'sub_categories.category_id');
        if (!empty($request->get('keyword'))) {
            $subcategories = $subcategories->where('sub_categories.name', 'like', '%' . $request->get('keyword') . '%');
            $subcategories = $subcategories->orWhere('categories.name', 'like', '%' . $request->get('keyword') . '%');
        }
        $subcategories = $subcategories->paginate(10);
        return view('sub_category.list')->with(['subcategories' => $subcategories]);
    }
    public function create()
    {
        $categories = Category::orderBy('name', 'ASC')->get();


        return view("sub_category.create", ["categories" => $categories]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:categories',
            'status' => 'required|boolean',
            'category_id' => 'required|not_in:0'

        ]);

        $subcategory = SubCategory::create($validatedData);

        $request->session()->flash('success', 'SubCategory Created Successfully');
        return response()->json([
            'status' => true,
            'message' => 'SubCategory Created Successfully'
        ]);
    }

    public function edit($id, Request $request)
    {
        $subcategory = SubCategory::find($id);
        if (empty($subcategory)) {
            $request->session()->flash("fail", "SubCategory Not Found");
            return redirect()->route("show.subcategory");
        }

        $categories = Category::orderBy('name', 'ASC')->get();



        return view("sub_category.edit-subcategory", ['subcategory' => $subcategory, 'categories' => $categories]);
    }

    //Subcategory Update Functionality
    public function update($subcategory, Request $request)
    {

        $subcategory = SubCategory::find($subcategory);
        if (empty($subcategory)) {
            $request->session()->flash("error", "SubCategory Not Found");
            return response()->json([
                "status" => false,
                'notFound' => true
            ]);
        }

        $validatedData = $request->validate([
            // 'name' => 'required|string|max:255',
            'slug' => [
                'required',
                'string',
                'max:255',
                Rule::unique('sub_categories', 'slug')->ignore($subcategory->id, 'id'),
            ],
            'status' => 'required|boolean',
            'category_id' => 'required|exists:categories,id',
        ]);
        $subcategory->name = $request->name;
        $subcategory->slug = $request->slug;
        $subcategory->status = $request->status;
        $subcategory->category_id = $request->category_id;
        $subcategory->save();

        $request->session()->flash('success', 'SubCategory Updated Successfully');
        return response()->json([
            'status' => true,
            'message' => 'SubCategory Updated Successfully'
        ]);
    }


    public function destroy(Request $request, $id)
    {
        try {
            $category = SubCategory::find($id);
            if (!$category) {
                $request->session()->flash('error', 'SubCategory not found');
                return response()->json(['error' => 'SubCategory not found'], 404);
            } else {
                $category->delete();
                $request->session()->flash('success', 'SubCategory Deleted Success');
                return response()->json([
                    'status' => true,
                    'message' => 'SubCategory Deleted Successfully'
                ]);
            }
        } catch (\Exception $e) {
            // Log the error
            \Log::error('Error deleting category: ' . $e->getMessage());

            // Return an error response
            return response()->json(['error' => 'An error occurred while deleting the category'], 500);
        }
    }
}
