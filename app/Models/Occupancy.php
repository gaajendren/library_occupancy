<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Occupancy extends Model
{
    protected $table = 'occupancy';
    
    protected $fillable = [
        'Date',
        'Count'
    ];

}
