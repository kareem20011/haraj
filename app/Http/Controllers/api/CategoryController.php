<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($lang)
    {
        $data = Category::with(['subcategories'])->select('id', "name_{$lang} as name")->orderBy('created_at', 'desc')->get();

        if (!$data) {
            return response()->json(['message' => 'no data found'], 404);
        }

        $data->map(function ($product) {
            $product['image'] = $product->getFirstMediaUrl();
            return $product;
        });

        return response()->json([
            'message' => 'categories has been fetched.',
            'data' => $data
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'image' => 'required|file|image|mimes:webp,jpeg,png,jpg,gif|max:5048',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        // Retrieve the validated data
        $validatedData = $validator->validated();

        // Create the category
        $cat = Category::create([
            'name_ar' => $validatedData['name_ar'],
            'name_en' => $validatedData['name_en'],
        ]);

        if ($request->hasFile('image')) {
            $cat->addMediaFromRequest('image')->toMediaCollection();
        }

        return response()->json(['message' => 'Category created successfully'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = Category::with('subcategories.products')->find($id);
        if (!$data) {
            return response()->json(['message' => 'no data found'], 404);
        }

        $data['image'] = $data->getFirstMediaUrl();

        return response()->json(['message' => 'category fetched', 'data' => $data], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json([
                'success' => false,
                'message' => 'category not found',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'name_ar' => 'sometimes|string|max:255',
            'name_en' => 'sometimes|string|max:255',
            'image' => 'sometimes|file|image|mimes:webp,jpeg,png,jpg,gif|max:5048',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        };

        $validatedData = $validator->validate();

        $category->update($validatedData);

        // add or update images
        if ($request->hasFile('image')) {
            // removing the old images
            $category->clearMediaCollection();

            // add the new images
            $category->addMediaFromRequest('image')->toMediaCollection();
        }

        return response()->json([
            'success' => true,
            'message' => 'category updated successfully',
            'data' => $category,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json([
                'success' => false,
                'message' => 'category not found',
            ], 404);
        }

        $category->clearMediaCollection();
        $category->delete();

        return response()->json([
            'success' => true,
            'message' => 'category deleted successfully',
        ], 200);
    }
}
