<?php

namespace App\Http\Controllers;

use App\Mail\MerchantOnboarded;
use App\Mail\WelcomeMerchant;
use App\Models\Merchant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class MerchantController extends Controller
{
    public function index()
    {
        return view('admin.merchants.onboard-merchant');
    }
    public function onboard(Request $request)
    {
        // Validate request data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:15',
            'email' => 'required|email',
            'location' => 'required|string|max:255',
            'payment_methods' => 'required|string', // This will be converted to JSON
            'business_name' => 'required|string|max:255',
            'drop_zone' => 'required|string|max:255',
            'business_category' => 'required|string|max:255',
            'password' => 'required|string|confirmed|min:6',
        ]);

        // Check if user already exists
        $user = User::where('email', $request->email)->first();
        // Generate a random password if not provided
        $password = $request->password ?? Str::random(8);

        if ($user) {
            // Update the existing user to be a merchant
            $user->update(['user_type' => 'merchant', 'password' => Hash::make($password)]);
        } else {
            // Create a new user
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone_number,
                'address' => $request->location,
                'password' => Hash::make($request->password),
                'user_type' => 'merchant', // Setting user type to merchant
            ]);
        }

        // Create the merchant entry
        $merchant = Merchant::create([
            'business_name' => $request->business_name,
            'location' => $request->location,
            'payment_methods' => json_encode(explode(',', $request->payment_methods)), // Convert to JSON
            'drop_zone' => $request->drop_zone,
            'business_category' => $request->business_category,
            'shop_unique_link' => Str::slug($request->business_name) . '-' . Str::random(8), // Generate a unique shop link
            'user_id' => $user->id, // Associate with the user
        ]);

        // Send welcome email to the merchant with login details
        Mail::to($user->email)->send(new WelcomeMerchant($merchant, $user, $password));

        // Fetch admin users to notify them
        $admins = User::where('is_admin', 1)->get();

        foreach ($admins as $admin) {
            Mail::to($admin->email)->send(new MerchantOnboarded($merchant));
        }
        return back()->with('success', 'New merchant added successfully!');
    }


    public function login(Request $request)
    {
        // Handle merchant login logic
    }

    public function dashboard()
    {
        // Display merchant dashboard
    }
}
