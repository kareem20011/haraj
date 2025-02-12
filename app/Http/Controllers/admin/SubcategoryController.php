<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubcategoryController extends Controller
{
    public function index()
    {
        $subcats = Subcategory::with(['category:id,name_ar,name_en'])->get();

        return view('admin.subcategories.index', compact('subcats'));
    }

    public function create()
    {
        $cats = Category::all();
        return view('admin.subcategories.create', compact('cats'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:5048',
            'category_id' => 'required|max:255|exists:categories,id',
        ]);

        $validatedData = $validator->validate();

        $cat = Subcategory::create($validatedData);

        if ($request->hasFile('image')) {
            $cat->addMediaFromRequest('image')->toMediaCollection();
        }

        return back()->with('success', __('contents.subcategories-created'));
    }

    public function edit($id)
    {
        $subcat = Subcategory::with('category')->find($id);
        $cats = Category::all();
        $selectedCategoryId = $subcat->category->id;
        return view('admin.subcategories.edit', compact('subcat', 'cats', 'selectedCategoryId'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name_ar' => 'sometimes|string|max:255',
            'name_en' => 'sometimes|string|max:255',
            'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:5048',
            'category_id' => 'sometimes|max:255|exists:categories,id',
        ]);

        $validatedData = $validator->validate();

        $cat = Subcategory::find($id);
        $cat->update($validatedData);

        if ($request->hasFile('image')) {
            $cat->clearMediaCollection();
            $cat->addMediaFromRequest('image')->toMediaCollection();
        }

        return redirect()->route('admin.subcategories.index')->with('success', __('contents.subcategories-updated'));
    }

    public function delete($id)
    {
        $cat = Subcategory::find($id);
        $cat->clearMediaCollection();
        $cat->delete();
        return redirect()->route('admin.subcategories.index')->with('success', __('contents.subcategories-deleted'));
    }
}
