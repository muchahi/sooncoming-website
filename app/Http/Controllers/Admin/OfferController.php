<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class OfferController extends Controller
{
    // Show all products with a discount
   public function discounts()
{
    $offers = Product::with('category')
        ->whereNotNull('discount_percentage')
        ->get();

    return view('admin.offers.discounts', compact('offers'));
}


    // Remove discount from a product
 public function destroy($id)
{
    $product = Product::findOrFail($id);
    $product->delete();  // Delete the product

    return response()->json([
        'success' => true,
        'message' => 'Offer deleted successfully.'
    ]);
}


    // Update discount percentage for a product
    public function updateDiscount(Request $request, $id)
    {
        $request->validate([
            'discount_percentage' => 'required|numeric|min:0|max:100',
        ]);

        $product = Product::findOrFail($id);
        $product->discount_percentage = $request->discount_percentage;
        $product->save();

        return response()->json(['success' => true, 'message' => 'Discount updated successfully']);
    }

    public function gifts()
    {
        return view('admin.offers.gifts');
    }
}
