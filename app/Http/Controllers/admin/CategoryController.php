<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Service\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }


    public function index(Request $request)
    {
        $categories = Category::latest();
        if (!empty($request->get('keyword'))) {
            $categories = $categories->where('name', 'like', '%' . $request->get('keyword') . '%');
        }
        $categories = $categories->paginate(10);
        return view('category.list')->with(['categories' => $categories]);
    }

    public function create()
    {
        return view('category.create');
    }

    public function store(Request $request)
    {
        $category = $this->categoryService->storeCategory($request);

        if ($category) {
            return response()->json([
                'status' => true,
                'message' => 'Category Created Successfully'
            ]);
        } else {
            $request->session()->flash('fail', 'Category Creation Failed');
            return redirect()->route('show.category')->with('fail', 'Category Created Fail');
        }
    }

    public function edit(Request $request, $categoryId)
    {

        $category = Category::find($categoryId);
        if (!$category) {
            return redirect()->back()->with('success', 'Category Updated successfully.');
        } else {
            return view('category.edit-category', compact('category'));
        }
        return view('category.edit-category');
    }

    public function update(Request $request, $categoryId)
    {
        $category = $this->categoryService->updateCategory($request, $categoryId);

        if ($category) {
            return response()->json(['success' => 'Category Updated successfully.']);
        } else {
            return response()->json(['fail' => 'Category Updattion Fail'], 400);
        }
    }
    public function destroy(Request $request, $id)
    {
        try {
            $category = Category::find($id);
            if (!$category) {
                return response()->json(['error' => 'Category not found'], 404);
            } else {
                $category->delete();
                $request->session()->flash('success', 'Category Deleted Successfully');
                return response()->json([
                    'status' => true,
                    'message' => 'Category Deleted Successfully'
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
