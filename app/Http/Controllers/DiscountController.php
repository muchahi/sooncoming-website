<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Discount;

class DiscountController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index']);
    }

    public function index()
    {
        // Display all discounts
        $discounts = Discount::all();
        return view('discounts.index', compact('discounts'));
    }

    public function create()
    {
        return view('discounts.create');
    }

    public function store(Request $request)
    {
        // Store a new discount code
        $validated = $request->validate([
            'code' => 'required|unique:discounts',
            'discount_percentage' => 'required|numeric',
        ]);

        Discount::create($validated);

        return redirect()->route('discounts.index');
    }

    public function destroy(Discount $discount)
    {
        // Delete a discount code
        $discount->delete();

        return redirect()->route('discounts.index');
    }
}
