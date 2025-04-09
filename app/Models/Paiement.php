<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paiement extends Model
{
    protected $fillable = [
        'nom',
        'client_id',
        'type',
        'numero',
        'date',
        'status'
    ];
}
