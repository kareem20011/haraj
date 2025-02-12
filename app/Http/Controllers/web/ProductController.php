<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductRating;
use App\Models\Subcategory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index($Subcategory_id)
    {
        $locale = Session::get('locale', 'ar');
        $subcategory = Subcategory::select("name_{$locale} as name")->find($Subcategory_id);
        $products = Product::with(['subcategory' => function ($query) use ($locale) {
            $query->select('id', "name_{$locale}");
        }, 'creator'])
            ->where('subcategory_id', $Subcategory_id)
            ->orderBy('created_at', 'desc')
            ->get();
        return view('web.products.index', ['products' => $products, 'subcategory' => $subcategory]);
    }





    public function create($subcat)
    {
        $locale = Session::get('locale', 'ar');
        $subcategory = Subcategory::select('id', "name_{$locale} as name")->find($subcat);
        return view('web.products.create', compact('subcategory'));
    }





    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'subcategory_id' => 'required|integer|exists:subcategories,id',  // Ensure the subcategory_id exists in the subcategories table
            'images' => 'required|array|min:1',  // Ensure images is an array and at least 1 image is provided
            'images.*' => 'mimes:webp,jpg,jpeg,png,gif,bmp|max:5048',  // Each image should be a valid file type and not exceed 2MB
            'title' => 'required|string|max:255',  // Title is required and should not exceed 255 characters
            'description' => 'required|string',  // Description is required
            'price' => 'required|numeric|min:0',  // Price is required and must be a numeric value greater than or equal to 0
            'location' => 'required|string|max:255',  // Location is required and should not exceed 255 characters
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Retrieve the validated data
        $validatedData = $validator->validate();

        // Create a new product entry
        $product = new Product();
        $product->subcategory_id = $validatedData['subcategory_id'];
        $product->title = $validatedData['title'];
        $product->description = $validatedData['description'];
        $product->price = $validatedData['price'];
        $product->location = $validatedData['location'];
        $product->user_id = auth()->user()->id; // Assuming the product is associated with the authenticated user
        $product->save();

        // Handle the images and associate them with the product using Spatie Media Library
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $product->addMedia($image)
                    ->toMediaCollection();
            }
        }


        return redirect()->route('home')->with('success', __('contents.product-created'));
    }





    public function show($product_id)
    {
        $product = Product::with('creator', 'subcategory', 'comments.user')->find($product_id);
        $user = User::find(auth()->user()->id);

        $product->subcategory_name = session('locale', 'ar') == 'ar' ? $product->subcategory->name_ar : $product->subcategory->name_en;

        $relatedProducts = Subcategory::with(['products' => function ($query) {
            $query->latest()->take(PAGINATE);
        }])->find($product->subcategory->id)->products;

        $comments = $product->comments;

        $isFavor = $user->favorites()->where('product_id', $product->id)->exists();

        return view('web.products.show', compact(
            'product',
            'relatedProducts',
            'comments',
            'isFavor',
        ));
    }




    public function edit($id)
    {
        $product = Product::find($id);
        return view('web.products.edit', compact('product'));
    }




    public function update(Request $request, $productId)
    {
        // Validate the request
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'location' => 'required|string',
            'images' => 'nullable|array',  // Allow array for multiple images
            'images.*' => 'mimes:webp,jpg,jpeg,png,gif,webp|max:2048',  // Validation for images
        ]);

        // Find the product by ID
        $product = Product::findOrFail($productId);

        // Update other product details
        $product->update([
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price,
            'location' => $request->location,
        ]);

        // Check if images are uploaded
        if ($request->has('images')) {
            $product->clearMediaCollection();

            // Loop through the images and add them to the media library
            foreach ($request->file('images') as $image) {
                $product->addMedia($image)
                    ->toMediaCollection();
            }
        }

        return redirect()->route('products.show', $productId)->with('success', 'Product updated successfully!');
    }





    public function delete($id)
    {
        $product = Product::with('creator')->find($id);
        if ($product->creator->id == auth()->user()->id) {
            $product->clearMediaCollection();
            $product->delete();
            return redirect()->route('home')->with('success', __('contents.product-deleted'));
        }
        abort(401);
    }




    public function search(Request $request)
    {
        $query = $request->get('search');
        $products = Product::where('title', 'like', '%' . $query . '%')->orderBy('created_at', 'desc')->get();

        // return response()->json($products);
        return view('web.products.search-result', compact('products'));
    }




    public function filter(Request $request)
    {
        $minPrice = $request->input('min_price', 0);
        $maxPrice = $request->input('max_price', null);
        $city = $request->input('city', null);

        $query = Product::query();

        if ($city != 'all') {
            $query->where('location', $city);
        }

        if ($minPrice) {
            $query->where('price', '>=', $minPrice);
        }
        if ($maxPrice) {
            $query->where('price', '<=', $maxPrice);
        }

        $products = $query->orderBy('created_at', 'desc')->get();

        return view('web.products.search-result', compact('products'));
    }
}
