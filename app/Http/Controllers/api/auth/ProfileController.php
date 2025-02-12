<?php

namespace App\Http\Controllers\api\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function show(Request $request)
    {
        if ($request->user()) {
            return response()->json([
                'message' => 'Profile fetched.',
                'data' => $request->user()
            ], 200);
        } else {
            return response()->json([
                'message' => 'Not authanticated!',
            ], 401);
        }
    }
}
