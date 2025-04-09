<?php

namespace App\Models;

use DateTime;
use Illuminate\Support\Facades\Storage;
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
        'like',
        'status',
    ];

    public function menus()
    {
        return $this->belongsToMany(Menu::class, 'plat_menu', 'plat_id', 'menu_id');
    }

    public function paniers()
    {
        return $this->hasMany(Panier::class, );
    }

    public function toArray()
    {
        $date = new DateTime($this->created_at);
        $url = Storage::disk('public')->url($this->photo);
        if (strpos($url, 'http://localhost') !== false) {
            $url = str_replace('http://localhost', 'http://localhost:8000', $url);
        }

        return [
            "id" => $this->id,
            "nom" => $this->nom,
            "details"=>$this->details,
            "photo" => $url,
            "status" => $this->status,
            "prix" => $this->prix,
            "commandes" => $this->commandes,
            "like" => $this->like,
            "created_at"=>$this->created_at,
            "date" => strftime('%A, %d %B %Y à %Hh%M', $date->getTimestamp())
        ];
    }
}
