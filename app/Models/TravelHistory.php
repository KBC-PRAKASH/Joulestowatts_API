<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TravelHistory extends Model
{
    use HasFactory;

    protected $table = "city_travel_history";

    protected $fillable = [
        'traveller_id', 'city_id', 'from_date', 'to_date'
    ];

    
}
