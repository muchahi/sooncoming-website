<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'quantity'];

    // Relationship with Product (One-to-One)
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
