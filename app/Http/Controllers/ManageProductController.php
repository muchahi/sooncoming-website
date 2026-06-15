<?php

namespace App\Http\Controllers;

use App\Models\ProductCategory;
use App\Models\ProductType;
use Illuminate\Http\Request;

class ManageProductController extends Controller
{


    public function create()
    {
        $categories = ProductCategory::all();
        $types = ProductType::all();
        return view('admin.product.add', compact('categories', 'types'));
    }


    public function createCategory()
    {
        // Return a view to add a new category
        return view('admin.product.category');
    }

    public function createType()
    {
        // Return a view to add a new product type
        return view('admin.product.type');
    }
}
