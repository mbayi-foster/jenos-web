<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rapport extends Model
{
    protected $fillable = [
        'commande_id',
        'livreur_id',
        'label',
        'contenue', // Assuming you want to store a comment
    ];
}
