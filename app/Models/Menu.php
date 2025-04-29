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
        $url = Storage::disk('public')->url($this->photo);
        if (strpos($url, 'http://localhost') !== false) {
            $url = str_replace('http://localhost', 'http://localhost:8000', $url);
        }
        return [
            "id" => $this->id,
            "nom" => $this->nom,
            "details" => $this->details,
            "photo" => $url,
            "status"=>$this->status,
            'count' => $this->plats->count(),
            "created_at" => $this->created_at
        ];
    }
}
