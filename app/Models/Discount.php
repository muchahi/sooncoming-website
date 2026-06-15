<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'discount_percentage',
        'start_date',
        'end_date',
        'active',
    ];

    /**
     * Check if the discount is currently active based on the date and status.
     *
     * @return bool
     */
    public function isActive()
    {
        $now = now();
        return $this->active && $this->start_date <= $now && $this->end_date >= $now;
    }
}
