<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model as Eloquent;
use App\Models\School;

class Student extends Eloquent
{
    protected $connection = 'mongodb';

    protected $fillable = [
        'name',
        'genre',
        'school_id',
    ];

    public function school()
    {
        return $this->belongsTo(School::class, 'school_id');
    }
}