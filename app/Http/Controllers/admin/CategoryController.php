<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function index()
    {
        $cats = Category::all();
        return view('admin.categories.index', compact('cats'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function edit($id)
    {
        $cat = Category::find($id);
        return view('admin.categories.edit', compact('cat'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name_ar' => 'sometimes|string|max:255',
            'name_en' => 'sometimes|string|max:255',
            'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:5048'
        ]);

        $validatedData = $validator->validate();

        $cat = Category::find($id);
        $cat->update($validatedData);

        if ($request->hasFile('image')) {
            $cat->clearMediaCollection();
            $cat->addMediaFromRequest('image')->toMediaCollection();
        }

        return redirect()->route('admin.categories.index')->with('success', __('contents.categories-updated'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:5048'
        ]);

        $validatedData = $validator->validate();

        $cat = Category::create($validatedData);

        if ($request->hasFile('image')) {
            $cat->addMediaFromRequest('image')->toMediaCollection();
        }

        return back()->with('success', __('contents.categories-created'));
    }

    public function delete($id)
    {
        $cat = Category::find($id);
        $cat->clearMediaCollection();
        $cat->delete();
        return redirect()->route('admin.categories.index')->with('success', __('contents.categories-deleted'));
    }
}
