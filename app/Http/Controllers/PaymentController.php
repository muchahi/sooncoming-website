<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Cart;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    public function processPayment(Request $request)
    {
       
        // Validate the payment mode
        $validated = $request->validate([
            'payment_mode' => 'in:pay_on_delivery,pay_now',  // Ensures payment mode is valid
            'address_id' => 'required|exists:shipping_addresses,id',  // Make sure address exists
            'guest_phone' => 'nullable|string',  // Allow guests to provide a phone number
        ]);
    
        $paymentMode = $validated['payment_mode'];
        $address_id = $validated['address_id'];
        $guestPhone = $request->guest_phone ?? null; // Capture guest phone if provided
        
        $paymentstatus = 'pending';
        
         if ($paymentMode === 'pay_now') {
            // Logic for "Pay Now"
            $paymentstatus = 'pending';
        } elseif ($paymentMode === 'pay_on_delivery') {
            // Logic for "Pay on Delivery"
            $paymentstatus = 'ondelivery';
        }
    
        // Save the order before proceeding with payment
        $order = $this->saveOrder($paymentMode, $address_id, $guestPhone, $paymentstatus);
    
        if ($paymentMode === 'pay_now') {
            // Logic for "Pay Now"
         $orderId = $order->id ?? 1;
         return view('payment.process', compact('orderId'));

           
        } elseif ($paymentMode === 'pay_on_delivery') {
            // Logic for "Pay on Delivery"
          
            return $this->handlePayOnDelivery($order);
        }
    
        
    
        // If somehow neither option is selected, return to the form with an error
        return redirect()->back()->withErrors(['payment_mode' => 'Invalid payment mode selected.']);
    }
   private function saveOrder($paymentMode, $address_id, $guestPhone = null, $paymentstatus)
   {
        // Get cart items based on authentication status
        if (Auth::check()) {
            $cartItems = Cart::where('user_id', Auth::id())->with('product')->get();
            $userId = Auth::id();
        } else {
            $cartItems = collect(session()->get('cart', [])); // Ensure it's a collection
            $userId = null;
        }
    
        // If no cart items, return false
        if ($cartItems->isEmpty()) {
            return false;
        }
    
        // Calculate subtotal
        $subtotal = $cartItems->sum(fn($item) => 
            ($item['quantity'] ?? $item->quantity) * 
            ($item['product']['price'] ?? $item->product->price)
        );
    
        // Fetch delivery cost from config
        $deliveryCost = config('app.delivery_cost', 0);
        $totalAmount = $subtotal + $deliveryCost;
    
        // Create the order (single entry in orders table)
        $order = Order::create([
            'user_id' => $userId,
            'guest_phone' => $guestPhone,
            'total_amount' => $totalAmount,
            'status' => $paymentMode === 'pay_now' ? 'pending' : 'waiting_for_delivery',
            'shipping_address' => $address_id,
            'payment_status' => $paymentstatus,
        ]);
    
        // Prepare order products for bulk insertion
        $orderProducts = $cartItems->map(fn($item) => [
            'order_id'   => $order->id,
            'product_id' => $item['product_id'] ?? $item->product->id,
            'quantity'   => $item['quantity'] ?? $item->quantity,
            'price'      => $item['product']['price'] ?? $item->product->price,
            'status'     => 'pending', // Default status for order items
            'created_at' => now(),
            'updated_at' => now(),
        ])->toArray();
    
        // Insert order products into order_product table (bulk insert)
        OrderProduct::insert($orderProducts);
        
         // ✅ Clear cart after order placement
        if (Auth::check()) {
            // If logged in, delete from database cart
            Cart::where('user_id', Auth::id())->delete();
        } else {
            // If guest, remove cart from session
            session()->forget('cart');
        }
    
        return $order;
    }


    private function handlePayOnDelivery($order)
    {
        // Order placed with "Pay on Delivery" status
        $order->status = 'waiting_for_delivery';
        $order->save();
        
        //create pending payment
        Payment::create([
        'user_id'        => Auth::id(),
        'order_id'       => $order->id,
        'amount'         => $order->total_amount,
        'payment_method' => 'pay_on_delivery',
        'payment_status' => 'pending',
        'mpesa_code'     => "n/a",
    ]);
    
        return redirect()->route('payment.success')->with('status', 'Your order has been placed. Pay on delivery!');
    }
   

      public function sendMobilePrompt(Request $request)
      {
        // Get the payment details from the request
        $amount = $request->amount;
        $mpesa = $request->phone;
        $orderid = $request->orderid;
    
        // Define API details for Mpesa or other payment providers
        $apikey = "gzCMQygjQ2DlXyyCnctW9pNHWzbVGsyh5gFj7gNl7mI1yhX40iVOzjxRDXoY";
        $channel = '60';  // Channel for payment
    
        // Prepare the POST data
        $postData = [
            "api_key" => $apikey,
            "orderNo" => $orderid,  // Order ID as a reference
            "amount" => $amount,
            "phone_number" => $mpesa,
            "user_reference" => $orderid,
            "payment_id" => $channel,
            "callback_url" => "https://sooncomming.store/api/callback",
            "remarks" => "Payment for Order #$orderid",
        ];
        
        //dd($postData);
    
        // Make the payment request using Laravel's Http client
        $response = Http::post('https://trustline.co.ke/api/v1/mpesa/express', $postData);
    
        // Log the entire response to check for errors
        Log::info('Payment API Response:', [
            'status' => $response->status(),
            'body' => $response->body(),
            'json' => $response->json()
        ]);
        
        // Check if the request was successful
        if ($response->successful()) {
            return back()->with('success', 'Please enter Mpesa PIN to confirm the payment');
        } else {
            
            return back()->with('error', 'Payment initiation failed. Please use the paybill payment method');
        }
    }


    public function checkPaymentStatus(Request $request, $order_id)
    {
        // Simulate a check on the payment status from an external API (like Mpesa or Visa)
        // This could involve calling an API or checking the payment gateway status
    
        // Here, we're simulating it by checking if the payment was approved
        $order = Order::find($order_id);
    
        // Simulate payment checking logic
        if ($order && $order->status === 'approved') {
            return response()->json(['status' => 'approved']);
        }
    
        // If payment is not approved or failed, return failure status
        return response()->json(['status' => 'failed']);
    }


    public function checkPayment($order_id)
    {
        $order = Order::find($order_id);
        return view('payment.check')->with("order", $order);
    }
    public function paymentFail(Request $request)
    {
        return view("payment.fail")->with("order", "failed");
    }
    
        public function paymentSuccess(Request $request)
    {
        return view("payment.success")->with("order", "Order Success we are processing");
    }
    
  


}
