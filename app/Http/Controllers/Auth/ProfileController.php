<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category; // Import Category model

class ProfileController extends Controller
{
    public function profile()
    {
        $categories = Category::all(); // Fetch categories
        return view('profile', compact('categories'));
    }
}
