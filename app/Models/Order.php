<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    
    protected $table = 'orders';

    protected $fillable = ['user_id', 'total_amount', 'status', 'shipping_address', 'product_id', 'payment_status'];

    // Relationship with User (Many-to-One)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function orderProducts()
    {
        return $this->hasMany(OrderProduct::class);
    }
    // App\Models\Order.php
public function products()
{
    return $this->belongsToMany(Product::class)->withPivot('status');
}




}
