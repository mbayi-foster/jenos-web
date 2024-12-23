<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    //
    protected $fillable = [];

    public function client(){
        return $this->belongsTo(Client::class, 'client');
    }

    public function livreur(){
        return $this->belongsTo(User::class, 'livreur');
    }
    public function livraisom(){
        return $this->belongsTo(User::class, 'livraison');
    }
}
