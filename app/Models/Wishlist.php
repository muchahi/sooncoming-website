<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Product;

class Wishlist extends Model
{
    use HasFactory;

    protected $table = 'wishlists';

    protected $fillable = ['user_id', 'product_id'];

    /**
     * Define relationship with User (Many-to-One)
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Define relationship with Product (Many-to-One)
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
