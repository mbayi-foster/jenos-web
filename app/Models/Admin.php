<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $fillable = [
        'user_id',
        'nom',
        'prenom',
        'phone',
        'photo',
        'status'
    ];

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_admin', 'admin_id', 'role_id');
    }

    

    public function toArray()
    {
        return [
            "id" => $this->id,
            "uid"=>$this->user_id,
            "prenom" => $this->prenom,
            "nom" => $this->nom,
            "email" => $this->users->email,
            "phone" => $this->phone,
            "photo" => $this->photo,
            "status" => $this->status,
            "created_at" => $this->created_at,
            "roles" => $this->roles,
            "notifications"=>$this->users->notifications
        ];

    }
}
