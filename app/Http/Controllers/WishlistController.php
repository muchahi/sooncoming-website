<?php
namespace App\Http\Controllers; 

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Wishlist;
use App\Models\Product;

class WishlistController extends Controller
{
    // Display the user's wishlist
    
    public function index()
{
    // For guests, retrieve wishlist items from session (if any)
    $wishlistItems = session()->get('wishlist', []);

    // For logged-in users, fetch from database
    if (Auth::check()) {
        $wishlistItems = Auth::user()->wishlists;
    }

    return view('wishlist.index', compact('wishlistItems'));
}

   public function addToWishlist(Product $product)
{
    // For all users (logged in or guests), save the product to session
    $wishlist = session()->get('wishlist', []);
    $wishlist[] = $product->id;
    session()->put('wishlist', $wishlist);

    return redirect()->route('wishlist.index')->with('status', 'Product added to wishlist!');
}

    public function removeFromWishlist(Product $product)
{
    // For guests, remove the product from the session wishlist
    if (!Auth::check()) {
        $wishlist = session()->get('wishlist', []);

        // Remove the product from the wishlist
        if (($key = array_search($product->id, $wishlist)) !== false) {
            unset($wishlist[$key]);
        }

        // Save the updated wishlist back to the session
        session()->put('wishlist', array_values($wishlist));
    } else {
        // For authenticated users, use your original logic
        Wishlist::where('user_id', Auth::user()->id)
                ->where('product_id', $product->id)
                ->delete();
    }

    return redirect()->route('wishlist.index');
}





    public function toggleWishlist(Product $product)
{
    // Check if the user is logged in or not
    if (Auth::check()) {
        $userId = Auth::id();

        // For authenticated users, handle the wishlist in the database
        $wishlist = Wishlist::where('user_id', $userId)
                            ->where('product_id', $product->id)
                            ->first();

        if ($wishlist) {
            $wishlist->delete();
            return response()->json(['success' => true, 'action' => 'removed']);
        } else {
            Wishlist::create([
                'user_id' => $userId,
                'product_id' => $product->id
            ]);
            return response()->json(['success' => true, 'action' => 'added']);
        }
    } else {
        // For guests, handle the wishlist using the session
        $wishlist = session()->get('wishlist', []);

        if (in_array($product->id, $wishlist)) {
            // Remove the product from the wishlist if it exists
            $wishlist = array_diff($wishlist, [$product->id]);
            $action = 'removed';
        } else {
            // Add the product to the wishlist
            $wishlist[] = $product->id;
            $action = 'added';
        }

        // Save the updated wishlist back to the session
        session()->put('wishlist', array_values($wishlist));

        return response()->json(['success' => true, 'action' => $action]);
    }
}


    // ✅ Added: Handle adding to cart from the wishlist
    public function addToCartFromWishlist(Product $product)
{
    // Check if the user is logged in or not
    if (Auth::check()) {
        // If logged in, store the cart item in the database (modify as per your cart logic)
        // Example: Add product to authenticated user's cart in the database
    } else {
        // If not logged in, handle cart using session
        $cart = session()->get('cart', []);

        // Add product to session-based cart
        $cart[] = $product->id;

        // Save updated cart back to the session
        session()->put('cart', $cart);
    }

    return response()->json(['success' => true]); // Ensure JSON response is returned
}

}
