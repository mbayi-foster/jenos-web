<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TokenFcm extends Model
{
    protected $fillable = [
        'token',
        'user_id'
    ];
}
