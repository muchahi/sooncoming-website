<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'images',
        'description',
        'price',
        'stock',
        'merchant_id',
        'type_id',
        'category_id',
        'discount_percentage'
         
    ];

    // Relationship with Category (Many-to-One)
    
    public function category()
{
    return $this->belongsTo(ProductCategory::class);
}

    // Relationship with Cart (One-to-Many)
    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    // Many-to-Many relationship with Order (Include status)
    public function orders()
    {
        return $this->belongsToMany(Order::class)
            ->withPivot('quantity', 'price', 'status') // Include 'status'
            ->withTimestamps();
    }

    // Relationship with Wishlist (One-to-Many)
    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }

    // Relationship with Inventory (One-to-One)
    public function inventory()
    {
        return $this->hasOne(Inventory::class);
    }

    public function merchant()
    {
        return $this->belongsTo(Merchant::class);
    }

    // Relationship with Product Type (Many-to-One)
    public function ProductType()
    {
        return $this->belongsTo(ProductType::class);
    }

    public function images()
    {
        return $this->hasMany(Image::class);
    }
}
