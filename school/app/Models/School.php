<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    protected $connection = 'pgsql'; // Spécifie la connexion PostgreSQL

    protected $fillable = [
        'name', 
        'address', 
        'director_name'
    ];

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
}
