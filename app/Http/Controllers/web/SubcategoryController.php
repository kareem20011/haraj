<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class SubcategoryController extends Controller
{
    public function getSubcategoriesByCategory($category_id)
    {
        $lang = Session::get('locale');
        $data = Subcategory::select('id', "name_{$lang} as name")->where('category_id', $category_id)->orderBy('created_at', 'desc')->get();
        return view('web.subcategories.showSubcategories', ['data' => $data]);
    }

    public function showProducts($subcategory_id)
    {
        $subcategory = Subcategory::with('products')->find($subcategory_id);
        $catName = session('locale') == 'ar' ?  $subcategory->name_ar : $subcategory->name_en;
        $products = $subcategory->products;
        $quick_navigates = [];
        $categories = Category::with('subcategories')->get();
        $category = Category::with('subcategories')->find($subcategory->category_id);
        return view('web.products.showByCategory', [
            'products' => $products,
            'quick_navigates' => $quick_navigates,
            'catName' => $catName,
            'categories' => $categories,
            'category' => $category,
            'subcategory' => $subcategory
        ]);
    }

    public function create()
    {
        $mainCategories = Category::all();
        $subCategories = Subcategory::all();
        return view('web.subcategories.create', compact('mainCategories', 'subCategories'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category_id' => 'required|integer|exists:categories,id',
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
        ]);

        $validatedData = $validator->validate();

        Subcategory::create($validatedData);

        return back();
    }
}
