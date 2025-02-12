<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function productCreation()
    {
        $lang = Session::get('locale');
        $data = Category::select('id', "name_{$lang} as name")->orderBy('created_at', 'desc')->get();
        return view('web.categories.productCreation', ['data' => $data]);
    }

    public function showProducts($category_id)
    {
        $category = Category::with('products')->find($category_id);
        $catName = session('locale') == 'ar' ? $category->name_ar : $category->name_en;
        $quick_navigates = $category->getSubcategoriesWithLocalizedName();
        $categories = Category::with('subcategories')->get();
        
        foreach($categories as $row)
        {
            $row['name'] = Session::get('locale') == "ar" ? $row->name_ar : $row->name_en;
        }

        return view('web.products.showByCategory', [
            'quick_navigates' => $quick_navigates,
            'catName' => $catName,
            'category' => $category,
            'categories' => $categories
        ]);
    }

    public function create()
    {
        $mainCategories = Category::all();
        return view('web.categories.create', compact('mainCategories'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:webp,jpeg,png,jpg,gif|max:5048'
        ]);

        $validatedData = $validator->validate();

        $cat = Category::create($validatedData);

        if ($request->hasFile('image')) {
            $cat->addMediaFromRequest('image')->toMediaCollection();
        }

        return back();
    }
}
