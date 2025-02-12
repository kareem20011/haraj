<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductFavorites;
use App\Models\User;
use Illuminate\Http\Request;

class ProductFavoriteController extends Controller
{
    public function index()
    {
        $user_id = auth()->user()->id;

        $userWithFavProducts = User::with('favorites')->find($user_id);

        return view('web.favorites.index', compact('userWithFavProducts'));
    }

    public function store($product_id)
    {
        $user = User::find(auth()->user()->id);

        $product = Product::findOrFail($product_id);

        $user->favorites()->attach($product->id);

        return back()->with('success', __('contents.fav-add'));
    }

    public function destory($product_id)
    {
        $user = User::find(auth()->user()->id);

        $product = Product::findOrFail($product_id);

        $user->favorites()->detach($product->id);

        return back()->with('success', __('contents.fav-remove'));
    }
}
