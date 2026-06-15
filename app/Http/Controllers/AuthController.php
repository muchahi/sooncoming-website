<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;


class AuthController extends Controller
{
    public function register(Request $request)
    {
        // Only allow admin/merchant registrations, not general users
        if ($request->is('admin/*') || $request->is('merchant/*')) {
            $validated = $request->validate([
                'name' => 'required',
                'email' => 'required|email|unique:users',
                'password' => 'required|confirmed|min:6',
            ]);

            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => bcrypt($validated['password']),
            ]);

            Auth::login($user);

            return redirect()->route('admin.dashboard'); // Redirect admin users
        }

        return redirect()->route('home'); // Default for regular users
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // Redirect admin to admin dashboard, default users to home
            return Auth::user()->is_admin ? redirect()->route('admin.dashboard') : redirect()->route('home');
        }

        return back()->withErrors(['email' => 'Invalid credentials']);
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('home'); // Redirect to home after logout
    }

    public function profile()
{
    $user = Auth::user();
    $categories = Category::all(); // Fetch categories
    return view('auth.profile', compact('user', 'categories'));
}

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        // $user->update($request->all());

        return redirect()->back()->with('status', 'Profile updated successfully!');
    }
    public function handleAction(Request $request, $id)
{
    $order = Order::findOrFail($id);
    $action = $request->input('action');

    switch ($action) {
        case 'cancel_order':
            $order->status = 'cancelled'; // or any other status value you use
            $order->save();
            return back()->with('success', 'Order has been cancelled.');

        case 'cancel_product':
            // If it's a specific product inside the order, handle that logic here
            // Example: $order->products()->update([...])
            $order->product_status = 'cancelled'; // or your actual logic
            $order->save();
            return back()->with('success', 'Product has been cancelled.');

        default:
            return back()->with('error', 'Unknown action.');
    }
}

}
