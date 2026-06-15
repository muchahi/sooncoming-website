<?php

namespace App\Http\Controllers;

use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductCategoryController extends Controller
{
    public function index()
    {
        $categories = ProductCategory::all(); // Fetch all categories
        return view('admin.categories.index', compact('categories')); // Create this Blade file
    }
    public function create()
    {
        return view('admin.categories.create'); // Create this Blade file
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'revenue' => 'required|string|max:255',
        ]);

        ProductCategory::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'revenue' => $request->revenue
        ]);

        return redirect()->route('admin.category.create')->with('success', 'Category added successfully!');
    }
}
