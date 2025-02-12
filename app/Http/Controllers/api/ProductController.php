<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Product::with('creator', 'subcategory')->orderBy('created_at', 'desc')->get();

        $data->map(function ($product) {
            // استرجاع روابط الصور
            $product['images'] = $product->getMedia('images')->map(function ($media) {
                return $media->getUrl();  // الحصول على رابط الصورة
            });

            return $product;
        });


        return response()->json([
            'success' => true,
            'message' => 'products has been fetched.',
            'data' => $data
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'location' => 'required|string|max:255',
            'subcategory_id' => 'required|exists:subcategories,id',
            'images' => 'required',
            'images.*' => 'nullable|image|mimes:webp,jpeg,png,jpg,gif|max:5048', // image size 5mb
        ]);

        // return validation errors
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }

        // get validated data
        $validatedData = $validator->validated();

        // check authantication
        if ($request->user()) {

            //creator data
            $validatedData['user_id'] = $request->user()->id;

            // store product data
            $product = Product::create($validatedData);

            // store images for product
            if ($request->has('images')) {
                foreach ($request->file('images') as $image) {
                    $product->addMedia($image)->toMediaCollection();
                }
            }

            // return success
            return response()->json([
                'success' => true,
                'message' => 'Product created successfully',
            ], 201);
        } else {

            // return 401 if not authanticated
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized. User not authenticated.'
            ], 401);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // find data
        $product = Product::find($id);

        // check if not found
        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'no data found'
            ], 404);
        }

        // Get images URLs
        $imageUrls = $product->getMedia()->map(function ($media) {
            return $media->getUrl();
        });

        // return data with 200 ok
        return response()->json([
            'success' => true,
            'message' => 'product fetched',
            'data' => [
                'product' => $product,
                'image_url' => $imageUrls
            ]
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Get product data
        $product = Product::find($id);

        // return 404 if not found
        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found',
            ], 404);
        }

        // validate inputs
        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'price' => 'sometimes|numeric|min:0',
            'location' => 'sometimes|string|max:255',
            'subcategory_id' => 'sometimes|exists:categories,id',
            'images.*' => 'nullable|image|mimes:webp,jpeg,png,jpg,gif|max:5048', // السماح برفع صور
        ]);

        // return validator errors
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }

        // get validated data
        $validatedData = $validator->validated();

        // update data
        $product->update($validatedData);

        // add or update images
        if ($request->has('images')) {
            // removing the old images
            $product->clearMediaCollection();

            // add the new images
            foreach ($request->file('images') as $image) {
                $product->addMedia($image)->toMediaCollection();
            }
        }

        // return 200 if update successfully
        return response()->json([
            'success' => true,
            'message' => 'Product updated successfully',
            'data' => $product,
        ], 200);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'product not found',
            ], 404);
        }

        // removing the old images
        $product->clearMediaCollection();

        // delete product
        $product->delete();

        return response()->json([
            'success' => true,
            'message' => 'product deleted successfully',
        ]);
    }
}
