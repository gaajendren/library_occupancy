<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room_name extends Model
{
    protected $table = "rooms";

    protected $fillable = [
        'room_id',
        'name',
        'location'
    ];

    public function get_room_type()
    {
        return $this->belongsTo(Room::class, 'room_id', 'id');
    }

    public function get_reservations()
{
    return $this->hasMany(Reservation::class, 'roomId', 'id');
}
}
