<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    
    protected $fillable  = ['title', 'logo', 'banner', 'description', 'roi', 'exit_roi', 'frame', 'start_time' ,'end_time', 'is_manual', 'contact']; 

    protected $casts = [
        'roi' => 'array', 
        'exit_roi' => 'array',
        'frame' => 'array',
    ];
}
