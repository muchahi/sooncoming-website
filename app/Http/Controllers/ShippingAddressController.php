<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ShippingAddress;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ShippingAddressController extends Controller
{
    public function addAddress(Request $request)
    {
        $validated = $request->validate([
            'address_line_1' => 'required|string|max:255',
            'address_line_2' => 'nullable|string|max:255',
            'city' => 'required|string|max:100',
            
        ]);

        // Check if the user is authenticated
        if (auth()->check()) {
            // If the user is logged in, associate the address with the authenticated user
            $address = ShippingAddress::create([
                'user_id' => auth()->id(),
                'address_line_1' => $validated['address_line_1'],
                'address_line_2' => $validated['address_line_2'],
                'city' => $validated['city'],
                'state' => 'Nairobi',
                'postal_code' => '01000',
                'country' => 'kenya',
            ]);
        } else {
            // If the user is not logged in, save the address without linking to a user (guest)
            $address = ShippingAddress::create([
                'user_id' => null,  // No user association for guest addresses
                'address_line_1' => $validated['address_line_1'],
                'address_line_2' => $validated['address_line_2'],
                'city' => $validated['city'],
                 'state' => 'Nairobi',
                'postal_code' => '01000',
                'country' => 'kenya',
            ]);
        }

        return redirect('cart')->with('success', 'Address added, choose and proceed');
    }

    public function editAddress($id)
    {
        $address = ShippingAddress::findOrFail($id);

        return view('address.edit', compact('address'));
    }

    public function index(Request $request)
    {
         //logic to add to cart
         Cart::updateOrCreate(
                ['user_id' => Auth::user()->id ?? 0, 
                 'product_id' => request()->query('p')],
                ['quantity' => 1]
            );
            
        //check if has address
        
        $hasAddress = DB::table('shipping_addresses')->where('user_id', Auth::user()->id)->first();
        
        if($hasAddress){
            //resume to cart to cart
            return redirect('/cart');
        }
        
        return view('address.index');
    }

    // Handle the update
    public function updateAddress(Request $request, $id)
    {
        $validated = $request->validate([
            'address_line_1' => 'required|string|max:255',
            'address_line_2' => 'nullable|string|max:255',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'postal_code' => 'required|string|max:20',
            'country' => 'required|string|max:100',
        ]);

        $address = ShippingAddress::findOrFail($id);
        $address->update($validated);

        return redirect()->route('address')->with('success', 'Address updated successfully!');
    }
}
