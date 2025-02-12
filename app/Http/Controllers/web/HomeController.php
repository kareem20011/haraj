<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    public function index()
    {
        $products = Product::with('creator', 'subcategory')->orderBy('created_at', 'desc')->get();

        $products->map(function ($product) {
            // تحديد اسم الفئة الفرعية بناءً على اللغة في الجلسة
            $lang = session('lang', 'en');  // إذا لم توجد اللغة في الجلسة، نستخدم 'en' كافتراضي

            // اختر الاسم بناءً على اللغة
            $product['subcategory_name'] = $lang === 'ar' ? $product->subcategory->name_ar : $product->subcategory->name_en;

            return $product;
        });

        $products->map(function ($product) {
            // استرجاع روابط الصور
            $product['images'] = $product->getMedia('images')->map(function ($media) {
                return $media->getUrl();  // الحصول على رابط الصورة
            });
        });


        $lang = Session::get('locale');
        $quick_navigates = Subcategory::select('id', "name_{$lang} as name", 'category_id')->orderBy('created_at', 'desc')->get()->groupBy('category_id');
        // return $quick_navigates;

        $min_categories = Category::select('id', "name_{$lang} as name")->orderBy('created_at', 'desc')->paginate(PAGINATE);

        $cities = Product::select('location')->distinct()->pluck('location');

        return view('web.home.index', [
            'products' => $products,
            'quick_navigates' => $quick_navigates,
            'min_categories' => $min_categories,
            'cities' => $cities
        ]);
    }
}
