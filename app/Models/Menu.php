<?php

namespace App\Models;
use Illuminate\Support\Facades\Storage;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    //
    protected $fillable = [
        "nom",
        "details",
        "photo",
        "status"
    ];

    public function plats()
    {
        return $this->belongsToMany(Plat::class, "plat_menu", "menu_id", "plat_id");
    }

    public function toArray()
    {
        return [
            "id" => $this->id,
            "nom" => $this->nom,
            "details" => $this->details,
            "photo" => $this->photo,
            "status" => $this->status,
            'count' => $this->plats->count(),
            "created_at" => $this->created_at
        ];
    }
}
