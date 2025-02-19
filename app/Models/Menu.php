<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    //
    protected $fillable = [
        "nom",
        "details",
        "photo",
    ];

    public function plats()
    {
        return $this->belongsToMany(Plat::class, "plat_menu", "menu_id", "plat_id");
    }
}
