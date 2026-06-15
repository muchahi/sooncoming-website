<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pickup extends Model
{
    use HasFactory;

    protected $fillable = [
        'location_name',     // Name of the pickup location
        'address',           // Address of the pickup location
        'contact_number',    // Contact number for the pickup location
        'operating_hours',   // Operating hours of the pickup location
    ];
}
