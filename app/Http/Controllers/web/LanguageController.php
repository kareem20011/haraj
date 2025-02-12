<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LanguageController extends Controller
{
    public function index()
    {
        $lang = session()->get('locale') == 'ar' ? 'en' : 'ar';
        app()->setlocale($lang);
        session()->put('locale', $lang);
        return redirect()->back();
    }
}
