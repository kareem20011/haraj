<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubcategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($lang)
    {
        $data = Subcategory::with(['products', 'category'])->select('id', "name_{$lang} as name", 'category_id')->orderBy('created_at', 'desc')->get();

        if (!$data) {
            return response()->json(['message' => 'no data found'], 404);
        }

        $data->map(function ($product) {
            $product['image'] = $product->getFirstMediaUrl();
            return $product;
        });

        return response()->json([
            'message' => 'subcategories has been fetched.',
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
            'category_id' => 'required|string|max:255',
            'image' => 'required|file|image|mimes:webp,jpeg,png,jpg,gif|max:5048',
        ]);

        // Retrieve the validated data
        $validatedData = $validator->validated();

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $subCat = Subcategory::create($validatedData);

        // add the new images
        if ($request->hasFile('image')) {
            $subCat->addMediaFromRequest('image')->toMediaCollection();
        }

        return response()->json(['message' => 'Subcategory created successfully'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = Subcategory::with(['products', 'category'])->find($id);

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
        $data = Subcategory::find($id);

        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'name_ar' => 'sometimes|string|max:255',
            'name_en' => 'sometimes|string|max:255',
            'category_id' => 'nullable|integer|exists:categories,id',
            'image' => 'required|file|image|mimes:webp,jpeg,png,jpg,gif|max:5048',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $validatedData = $validator->validate();

        $data->update($validatedData);

        // add or update images
        if ($request->hasFile('image')) {
            // removing the old images
            $data->clearMediaCollection();

            // add the new images
            $data->addMediaFromRequest('image')->toMediaCollection();
        }

        return response()->json([
            'success' => true,
            'message' => 'data updated successfully',
            'data' => $data,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Subcategory::find($id);

        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'data not found',
            ], 404);
        }

        $data->delete();

        return response()->json([
            'success' => true,
            'message' => 'data deleted successfully',
        ], 200);
    }
}
