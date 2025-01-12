<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plat extends Model
{
    //
    protected $fillable = [
        'nom',
        'details',
        'photo',
        'prix',
        'is_offre',
        'like',
        'status',
    ];
}
