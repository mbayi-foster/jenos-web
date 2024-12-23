<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    //
    protected $fillable = [];

    public function plat(){
        return $this->belongsToMany(Plat::class);
    }
}
