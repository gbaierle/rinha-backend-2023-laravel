<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    use HasFactory;

    protected $table = 'person';

    // protected $primaryKey = null;

    protected $casts = [
        'birth_date' => 'date',
        'stack' => 'array',
    ];

    public $timestamps = false;

    public $incrementing = false;
}
