<?php

namespace App\Models;

use App\Enum\Roles;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    //
    protected $fillable = [
        'nom',
        'status'
    ];

    protected $casts = [
        'nom' => Roles::class,
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'role_user', 'role_id', 'user_id');
    }
}
