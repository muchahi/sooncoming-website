<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Merchant extends Model
{
    use HasFactory;

    protected $fillable = [
        'business_name',    // The business name of the merchant
        'location',         // The location of the business
        'payment_methods',   // JSON field for payment methods
        'drop_zone',        // Drop zone for deliveries
        'business_category', // Category of the business
        'shop_unique_link', // Unique link for the shop
        'user_id',          // Foreign key for the user
    ];

    public function categories()
    {
        return $this->hasMany(ProductCategory::class);
    }

    public function types()
    {
        return $this->hasMany(ProductType::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
