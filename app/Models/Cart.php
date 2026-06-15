<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'product_id', 'quantity'];

    // Relationship with User (Many-to-One)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship with Product (Many-to-One)
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
