<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Order;
use App\Models\Payment;
use App\Models\ShippingAddress;
use App\Models\Wishlist;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'address',
        'is_admin',
        'user_type',
        'is_verified',
        'preferred_language',
        'preferred_currency',
        'points',
        'preferred_timezone',
        'preferred_theme',
        'shipping_methods',
        'payment_methods',
        'preferred_payment_method',
        'country',
        'city',
        'postal_code',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'password' => 'hashed',
    ];

    /**
     * Define relationship with orders.
     * A user can have many orders.
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Define relationship with carts.
     * A user can have one cart.
     */
    public function cart()
    {
        return $this->hasOne(Cart::class);
    }

    /**
     * Define relationship with wishlists.
     * A user can have many wishlists.
     */
    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }

    /**
     * Define relationship with payments.
     * A user can have many payment methods.
     */
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * Define relationship with shipping addresses.
     * A user can have many shipping addresses.
     */
    public function shippingAddresses()
    {
        return $this->hasMany(ShippingAddress::class);
    }

    /**
     * Check if user is an admin.
     */
    public function isAdmin()
    {
        return $this->is_admin;
    }
}
