<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Person_exit extends Model
{
    protected $table = 'person_exit';
    protected $fillable =[
        'track_id',
        'embedding',
        'img',
        'timestamp'
    ];



}
