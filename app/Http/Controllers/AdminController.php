<?php

namespace App\Http\Controllers;

use App\Models\Merchant;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\AboutImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\CustomerMessageMail;
use App\Models\Message;
use Illuminate\Support\Facades\DB;




class AdminController extends Controller
{
    
    
    private function getOrdersold($filter, $statuses = [])
    {
        $query = Order::with(['user', 'orderProducts.product']);

        if (!empty($statuses)) {
            $query->whereIn('status', $statuses);
        }

        if ($filter === 'today') {
            $query->whereDate('created_at', now());
        } elseif ($filter === 'yesterday') {
            $query->whereDate('created_at', now()->subDay());
        } elseif ($filter === 'week') {
            $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
        }

        return $query->latest()->get();
    }
    public function dashboard()
    {
        // Admin dashboard view

        return view('admin.dashboard');
    }
    
    public function home()
    {
        // Admin dashboard view

        return view('admin.dashboard');
    }

    public function listAllUsers()
    {
        $users = User::all();
        return view('admin.users.list-users', compact('users'));
    }
    public function giftCard()
    {
        
        return view('admin.gifts.updategift.blade.php');
    }

    public function manageUsers()
    {
        // Admin can manage users here
    }

    public function manageOrders()
    {
        // Admin can manage orders here
    }

    public function manageProducts()
    {
        // Admin can manage products here
    }

    public function index()
    {
        // Admin dashboard
    }

    public function manageMerchants()
    {
        //dd("users");
        // Display all merchants
        $merchants = User::where('user_type', 'merchant')->get(); // Fetch all merchants from the database
        return view('admin.users.list-merchants', compact('merchants'));
    }
  public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }
    public function destroy(User $user)
{
    // Perform the deletion of the user
    $user->delete();

    // Redirect back or to a specific page with a success message
    return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
}
public function update(Request $request, User $user)
{
    // Validate the request
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255|unique:users,email,' . $user->id,  // Ignore unique check for the current user's email
        'phone_number' => 'required|string|max:20',
        'is_admin' => 'required|boolean',
    ]);

    // Update the user's data
    $user->update([
        'name' => $request->input('name'),
        'email' => $request->input('email'),
        'phone_number' => $request->input('phone_number'),
        'is_admin' => $request->input('is_admin'),
    ]);

    // Redirect with success message
    return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
}
public function confirmIndex()
{
    // Retrieve all users (or paginate if there are many users)
    $users = User::all(); // or use pagination: User::paginate(10);

    return view('admin.users.index', compact('users'));
}

    public function suspendMerchant($id)
    {
        // Suspend a merchant
    }
   

public function liveOrders(Request $request)
{
    // Step 1: Get current filter (default is 'today')
    $currentFilter = $request->input('filter', 'today');

    // Step 2: Define the statuses for live orders
    $liveStatuses = ['pending', 'dispatched'];

    // Step 3: Fetch the orders using your shared getOrders() helper
    $orders = $this->getOrders($currentFilter, $liveStatuses);

    // Step 4: Count totals for the summary cards
    $totalOrders = $orders->count();
    $totalPending = $orders->where('status', 'pending')->count();
    $totalDispatched = $orders->where('status', 'dispatched')->count();

    // Step 5: Return everything to the view
    return view('admin.orders.index', compact(
        'orders',
        'currentFilter',
        'totalOrders',
        'totalPending',
        'totalDispatched'
    ));
}

public function getOrders($filter = null, $statuses = [])
{
    $query = Order::query();

    // Apply filter based on status if it's not 'all'
    if ($filter && $filter !== 'all') {
        $query->whereIn('status', $statuses);
    }

    // Additional logic for filtering by date range, etc., if required.
    if ($filter === 'today') {
        $query->whereDate('created_at', today());
    } elseif ($filter === 'this_week') {
        $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
    } elseif ($filter === 'this_month') {
        $query->whereMonth('created_at', now()->month);
    }

    return $query->get();
}

public function orderHistory(Request $request)
{
    // Step 1: Get current filter (default is 'today')
    $currentFilter = $request->input('status', 'today');

    // Step 2: Define history-related statuses (exclude 'all' from here)
    $historyStatuses = ['completed', 'cancelled', 'returned']; 

    // Step 3: Determine if the filter is 'all' and adjust the query accordingly
    if ($currentFilter === 'all') {
        // If 'all' is selected, fetch all orders (no status filter)
        $orders = $this->getOrders();  // Get all orders without any filtering
    } else {
        // Otherwise, apply the filter to fetch orders with the selected status
        $orders = $this->getOrders($currentFilter, $historyStatuses);
    }

    // Step 4: Get stats for summary cards
    $totalOrders = $orders->count();
    $totalCompleted = $orders->where('status', 'completed')->count();
    $totalCancelled = $orders->where('status', 'cancelled')->count();
    $totalReturned = $orders->where('status', 'returned')->count();

    // Step 5: Return to view with necessary data
    return view('admin.orders.history', compact(
        'orders',
        'currentFilter',
        'totalOrders',
        'totalCompleted',
        'totalCancelled',
        'totalReturned'
    ));
}





private function applyFilters($query, $filter)
{
    // Apply filter logic based on the provided filter (date-related filters)
    switch ($filter) {
        case 'today':
            $query->whereDate('created_at', today());
            break;
        case 'yesterday':
            $query->whereDate('created_at', today()->subDay());
            break;
        case 'week':
            $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
            break;
        case 'all':
        default:
            // Show all orders without date filtering
            break;
    }

    return $query;
}


    // Handle Order Actions (Cancel Order, Cancel Product, Send Message)
    
public function handleAction(Request $request, Order $order)
{
    $action = $request->input('action');

    switch ($action) {
        case 'cancel_order':
            // Cancel logic...
            break;

        case 'cancel_product':
            // Cancel product logic...
            break;

        case 'send_message':
            $message = $request->input('message');

            Mail::to($order->user->email)->send(new CustomerMessageMail($message));

            Message::create([
                'order_id' => $order->id,
                'user_id' => $order->user->id,
                'message' => $message,
            ]);

            session()->flash('success', 'Message sent successfully.');
            break;

        case 'refund':
            // Refund logic here...
            // e.g., $order->update(['status' => 'refunded']);
            session()->flash('success', 'Refund processed.');
            break;
    }

    // 🔁 Redirect back to whatever page the action came from
    return redirect()->back();
}


// Method to handle sending a message to the order
public function sendMessage(Request $request, Order $order)
    {
        // Logic for sending a message (e.g., via email or notification)
        // For example, you could create a new message model and associate it with the order

        // Sample success message after sending the message
        return redirect()->route('admin.orders.history')->with('success', 'Message sent successfully.');
    }

// Method to handle processing a refund for the order

public function processRefund(Request $request, Order $order)
    {
        // Logic for refund processing (e.g., update order status, initiate payment refund)

        // Sample success message after processing the refund
        return redirect()->route('admin.orders.history')->with('success', 'Refund processed successfully.');
    }


public function sendMessageToCustomer(Request $request, $orderId)
{
    // Validate the incoming message
    $validated = $request->validate([
        'message' => 'required|string',
    ]);

    // Get the order and customer details
    $order = Order::findOrFail($orderId);
    $messageContent = $validated['message'];

    try {
        // Send the email to the customer
        Mail::to($order->user->email)->send(new CustomerMessageMail($messageContent));

        // Redirect with success message
        return redirect()->back()->with('success', 'Message sent to the customer successfully!');
    } catch (\Exception $e) {
        // Handle and show any error
        return redirect()->back()->with('error', 'Failed to send message: ' . $e->getMessage());
    }
}



public function editGiftCard($id)
{
    $giftCard = DB::table('gift_card')->where('image_id', $id)->first();
    return view('admin.gifts.edit_gift_card', compact('giftCard'));
}

public function updateGiftCard(Request $request, $id)
{
    $request->validate([
        'discount' => 'required|numeric',
        'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
    ]);

    $updateData = [
        'discount' => $request->discount,
    ];

    if ($request->hasFile('image')) {
        $image = $request->file('image');
        $filename = time() . '.' . $image->getClientOriginalExtension();
        $destinationPath = public_path('assets/img');

        // Move the uploaded image to public/assets/img/
        $image->move($destinationPath, $filename);

        $updateData['image'] = $filename;
    }

    DB::table('gift_card')->where('image_id', $id)->update($updateData);

    return redirect()->back()->with('success', 'Gift card updated successfully!');
}

   
public function uploadAboutImages(Request $request)
{
    if ($request->hasFile('image')) {
        $image = $request->file('image');

        $mime = $image->getMimeType();
        $size = $image->getSize();
        $allowedMimes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];


        $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('assets/about/'), $filename);

        DB::table('about_images')->insert(['filename' => $filename]);

        return redirect()->back()->with('success', 'Image uploaded successfully!');
    }

    return redirect()->back()->with('error', 'No image was uploaded.');
}





 public function showAboutUploadForm(Request $request)
{
    return view('admin.about-upload');
}



}
