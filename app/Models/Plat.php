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
        'qte', 
        'commandes',
        'is_offre',
        'like',
        'status',
    ];

    public function menus()
    {
        return $this->belongsToMany(Menu::class, 'plat_menu', 'plat_id', 'menu_id');
    }

    public function paniers(){
        return $this->hasMany(Panier::class,);
    }
}
