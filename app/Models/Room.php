<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;


    protected $table = "room_type";

   
    protected $fillable = [
        'img',
        'title', 
        'description',
        'min_seat',
        'max_seat',
        'location',
        'slot',
        'max_slot',
        'qty'
    ];

        public function rooms()
    {
        return $this->hasMany(Room_name::class, 'room_id', 'id');
    }
  
    
}
