<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = ['studentId', 'roomId', 'roomTypeId', 'time', 'date', 'status', 'studentCount', 'matric_pic','ticket_no'];

    public function get_room()
    {
        return $this->belongsTo(Room_name::class, 'roomId', 'id');
    }

    public function get_student()
    {
        return $this->belongsTo(User::class, 'studentId', 'id');
    }

    public function get_roomType()
    {
        return $this->belongsTo(Room::class, 'roomTypeId', 'id');
    }




}
