<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = ['studentId', 'roomId', 'time', 'date', 'status', 'studentCount', 'matric_pic'];

    public function get_room()
    {
        return $this->belongsTo(Room::class, 'roomId', 'id');
    }

    public function get_student()
    {
        return $this->belongsTo(User::class, 'studentId', 'id');
    }

}
