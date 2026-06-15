<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;


class NotificationController extends Controller
{
    public function index()
    {
        $categories = Category::all(); // Fetch all categories
        return view('notifications.index', compact('categories'));
    }
}
