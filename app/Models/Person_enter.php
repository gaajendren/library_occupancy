<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Person_enter extends Model
{
    protected $table = 'person_enter';
    protected $fillable =[
        'track_id',
        'person_id_exit',
        'embedding',
        'img',
        'timestamp'
    ];

    public function personExit()
    {
        return $this->belongsTo(Person_exit::class, 'person_id_exit', 'id');
    }

}
