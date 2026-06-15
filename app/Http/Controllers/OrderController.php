<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\ShippingAddress;
use App\Models\Cart;

class OrderController extends Controller
{
    public function index()
    {
        dd('hey...');
        $orders = Order::with('products')->get(); // Fetch all orders with products and status
        return view('orders.index', compact('orders'));
    }

    /**
     * Display a specific order.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        dd('hey----');
        $order->load('products'); // Ensure products and status are loaded
        return view('orders.show', compact('order'));
    }
    
    public function userOrders()
    {
        dd('hey====');
        $orders = Order::where('user_id', auth()->id())
                        ->with(['products' => function ($query) {
                            $query->withPivot('status'); // Include status from pivot table
                        }])
                        ->get();
    
        return view('orders.user', compact('orders'));
    }

    public function cancelOrder($id)
    {
        $order = Order::where('id', $id)->where('user_id', auth()->id())->first();

        if (!$order) {
            return response()->json(['error' => 'Order not found or unauthorized'], 404);
        }

        $order->status == 'cancelled';
        $order->save();

        return response()->json(['success' => 'Order cancelled successfully']);
    }

    public function address()
    {
        $cartItems = session('cart', collect()); // Get cart items for guests and logged-in users

        if (Auth::check()) {
            $cartItems = Cart::where('user_id', Auth::id())->with('product')->get();
        }

        $subtotal = collect($cartItems)->sum(function ($item) {
            return isset($item['quantity'], $item->product->price) ? $item['quantity'] * $item->product->price : 0;
        });

        return view('checkout.address', compact('subtotal'));
    }

    public function payment()
    {
        $cartItems = session('cart', collect());

        if (Auth::check()) {
            $cartItems = Cart::where('user_id', Auth::id())->with('product')->get();
        }

        $subtotal = collect($cartItems)->sum(function ($item) {
            return isset($item['quantity'], $item->product->price) ? $item['quantity'] * $item->product->price : 0;
        });

        return view('checkout.payment', compact('subtotal'));
    }

    public function editAddress($id)
    {
        return view('checkout.edit-address', compact('id'));
    }
public function track($id, Request $request)
{
    // Initialize the status log array
    $statusLog = [];

    // Load the order with its associated order products
    $order = Order::with('orderProducts')->find($id);

    // Check if the order exists
    if ($order) {
        // Generate status log based on the order's status
        switch ($order->status) {
            case 'pending':
                $statusLog[] = ['status_title' => 'Order Placed', 'status_type' => 'primary', 'created_at' => now()->subDays(2)];
                $statusLog[] = ['status_title' => 'Not Started Yet', 'status_type' => 'secondary', 'created_at' => now()->subDays(1)];
                break;

            case 'waiting_for_delivery':
                $statusLog[] = ['status_title' => 'Order Placed', 'status_type' => 'primary', 'created_at' => now()->subDays(2)];
                $statusLog[] = ['status_title' => 'Shipping', 'status_type' => 'success', 'created_at' => now()->subDay()];
                break;

            case 'approved':
                $statusLog[] = ['status_title' => 'Order Placed', 'status_type' => 'primary', 'created_at' => now()->subDays(2)];
                $statusLog[] = ['status_title' => 'Shipped', 'status_type' => 'success', 'created_at' => now()];
                break;

            default:
                $statusLog[] = ['status_title' => 'Unknown Status', 'status_type' => 'danger', 'created_at' => now()->subDays(3)];
                break;
        }

        // Attach the status log to the order
        $order->status_log = $statusLog;
    }

    // Return the view with the order
    return view('orders.track', compact('order'));
}

public function showOrderTracking($id)
{
    // Fetch the order with its related order products
    $order = Order::with('orderProducts.product')->find($id);

    // Ensure the order has an estimated delivery date
    if ($order) {
        // Assuming that estimated_delivery_date is in the related product model
        $order->estimated_delivery_date = $order->orderProducts->first()->product->estimated_delivery_date ?? null;
    }

    // Return the order tracking view
    return view('orders.track', compact('order'));
}




    public function orders()
    {
        // Retrieve orders with related products
        $orders = Order::with('orderProducts.product') // Load order items & products
            ->where('user_id', Auth::id())// Get only the logged-in user's orders
            
             ->where('status', '!=', 'cancelled')
            ->orderBy('created_at', 'desc') // Order by latest orders
            ->get();
    
        return view('orders.index', compact('orders'));
    }
    
     public function showOrderSummary($id)
     { 
        //  fetch only the delivered order that belong to the logged-in user
        $order = Order::with('orderProducts.product')
             ->where('id', $id)
             ->where('user_id', Auth::id())
             ->where('status','delivered')
             ->first();
             
        if(!$order){
            return redirect()->route('orders.history')->with('error', 'Order not delivered');
        }
        //  fetch the actual shipping address
         $shippingAddress = ShippingAddress::find($order->shipping_address);
        return view('orders.summary', compact('order','shippingAddress'));
     }

}
