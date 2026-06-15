<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Category;


class CartController extends Controller
{
    public function index(Request $request)
    {
        
        dd('hey');
        $product_id = $request->query('p');
        if ($product_id) {
            $actions = $request->query('action');
            $product = Product::findOrFail($product_id); // Fetch product details

            if (Auth::check()) {
                // User is logged in, use database cart
                $cart = Cart::updateOrCreate(
                    ['user_id' => Auth::user()->id, 'product_id' => $product->id],
                    ['quantity' => $request->quantity ?? 1]
                );
            } else {
                // User is not logged in, use session cart
                $cartItems = session()->get('cart', []);
                $cartItems[$product_id] = [
                    'product' => [
                        'id' => $product->id,
                        'name' => $product->name,
                        'price' => $product->price,
                        'image' => $product->image, // Ensure only necessary data is stored
                    ],
                    'quantity' => ($cartItems[$product_id]['quantity'] ?? 0) + ($request->quantity ?? 1),
                ];
                session()->put('cart', $cartItems);
            }
        }

        // Fetch cart items based on login status
        if (Auth::check()) {
            $cartItems = Cart::where('user_id', Auth::user()->id)->with('product')->get();
        } else {
            // Convert session cart to a collection with a consistent structure
            $cartItems = collect(session()->get('cart', []))->map(function ($item) {
                return (object) [
                    'quantity' => $item['quantity'],
                    'product' => (object) $item['product'], // Convert product array to object
                ];
            });
        }

        // Calculate subtotal
        $subtotal = $cartItems->sum(function ($item) {
            return $item->quantity * $item->product->price;
        });
        
        dd($subtotal);

        return view('cart.index', compact('cartItems', 'subtotal'));
    }
       
      public function showCart(Request $request)
       {
           
            $product_id = $request->query('p');
            if ($product_id) {
                $actions = $request->query('action');
                $product = Product::findOrFail($product_id); // Fetch product details
    
                if (Auth::check()) {
                    // User is logged in, use database cart
                    $cart = Cart::updateOrCreate(
                        ['user_id' => Auth::user()->id, 'product_id' => $product->id],
                        ['quantity' => $request->quantity ?? 1]
                    );
                } else {
                    // User is not logged in, use session cart
                    $cartItems = session()->get('cart', []);
                    $cartItems[$product_id] = [
                        'product' => [
                            'id' => $product->id,
                            'name' => $product->name,
                            'price' => $product->price,
                            'image' => $product->image, // Ensure only necessary data is stored
                        ],
                        'quantity' => ($cartItems[$product_id]['quantity'] ?? 0) + ($request->quantity ?? 1),
                    ];
                    session()->put('cart', $cartItems);
                }
            }
    
            // Fetch cart items based on login status
            if (!Auth::check()) {
                // Convert session cart to a collection with a consistent structure
                $cartItems = collect(session()->get('cart', []))->map(function ($item) {
                    return (object) [
                        'quantity' => $item['quantity'],
                        'product' => (object) $item['product'], // Convert product array to object
                    ];
                });
            }
               
            $userId = auth()->id(); // Ensure the user is authenticated
            $cartItems = Cart::where('user_id', $userId)->with('product')->get();
            
            
            
            
            // Calculate subtotal
            $subtotal = $cartItems->sum(function ($item) {
                return $item->product->price * $item->quantity;
            });
        
            return view('cart.index', [
                'cartItems' => $cartItems,
                'subtotal' => $subtotal
            ]);
        }


    

    public function addToCart(Request $request)
    {
        $product = Product::find($request->product_id);
        if (!$product) {
            return response()->json(['success' => false, 'message' => 'Product not found!'], 404);
        }

        if (Auth::check()) {
            // User is logged in, update database cart
            $cart = Cart::updateOrCreate(
                ['user_id' => Auth::id(), 'product_id' => $product->id],
                ['quantity' => DB::raw("quantity + 1")] // Increment quantity
            );
        } else {
            // User is not logged in, update session cart
            $cartItems = session()->get('cart', []);
            $cartItems[$product->id] = [
                'product' => [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => $product->price,
                    'image' => $product->image, // Store necessary product details
                ],
                'quantity' => ($cartItems[$product->id]['quantity'] ?? 0) + 1,
            ];
            session()->put('cart', $cartItems);
        }

        return response()->json([
            'success' => true,
            'message' => 'Product added to cart!',
        ]);
    }

    public function addToCartById(Request $request)
    {
        $product = Product::findOrFail($request->product_id); // Fetch product details

        if (Auth::check()) {
            // User is logged in, update database cart
            $cart = Cart::updateOrCreate(
                ['user_id' => Auth::user()->id, 'product_id' => $product->id],
                ['quantity' => $request->quantity ?? 1]
            );

            // Fetch cart items from database
            $cartItems = Cart::where('user_id', Auth::user()->id)->get();
        } else {
            // User is not logged in, update session cart
            $cartItems = session()->get('cart', []);
            $cartItems[$product->id] = [
                'product' => [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => $product->price,
                    'image' => $product->image, // Store necessary product details
                ],
                'quantity' => ($cartItems[$product->id]['quantity'] ?? 0) + ($request->quantity ?? 1),
            ];
            session()->put('cart', $cartItems);
        }

        // Calculate new subtotal and total
        $subtotal = collect($cartItems)->sum(function ($item) {
            return $item['product']['price'] * $item['quantity'];
        });

        // Add any additional charges or deductions if necessary
        $total = $subtotal; // Modify this if there are any additional charges (e.g., shipping, tax)

        return response()->json([
            'success' => true,
            'message' => 'Product quantity updated successfully!',
            'subtotal' => number_format($subtotal, 2),
            'total' => number_format($total, 2),
        ]);
    }

    public function removeFromCart($id)
    {
        if (Auth::check()) {
            // User is logged in, remove item from database cart
            $cartItem = Cart::where('id', $id)->first();
            if ($cartItem) {
                Cart::where('user_id', Auth::user()->id)->where('id', $id)->delete();
            }
        } else {
            // User is not logged in, remove item from session cart
            $cartItems = session()->get('cart', []);
            if (isset($cartItems[$id])) {
                unset($cartItems[$id]);
                session()->put('cart', $cartItems);
            }
        }

        return back()->with('success', 'Product removed from cart');
    }

    public function updateCart(Request $request, Product $product)
    {
        if (Auth::check()) {
            // User is logged in, update quantity in the database cart
            $cart = Cart::where('user_id', Auth::user()->id)->where('product_id', $product->id)->first();

            if ($cart) {
                $cart->update(['quantity' => $request->quantity]);
            }
        } else {
            // User is not logged in, update quantity in the session cart
            $cartItems = session()->get('cart', []);

            if (isset($cartItems[$product->id])) {
                $cartItems[$product->id]['quantity'] = $request->quantity;
                session()->put('cart', $cartItems);
            }
        }

        return redirect()->route('cart.index');
    }
} // This closing brace properly ends the CartController class
