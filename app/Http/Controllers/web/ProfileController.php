<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index()
    {
        // $user = auth()->user();
        $user = User::with('products')->find(auth()->user()->id);
        // return 
        return view('web.profile.index', compact('user'));
    }

    public function edit()
    {
        $user = auth()->user();
        return view('web.profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = User::find(auth()->user()->id);

        // التحقق من البيانات
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'avatar' => 'nullable|image|mimes:webp,jpeg,png,jpg,gif|max:2048',
        ]);

        // تحديث البيانات
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->address = $request->address;

        // تحديث الصورة الشخصية
        if ($request->hasFile('avatar')) {
            $user->clearMediaCollection();
            $user->addMediaFromRequest('avatar')->toMediaCollection();
        }

        $user->save();

        return redirect()->route('profile.index')->with('success', __('Profile updated successfully.'));
    }
}
