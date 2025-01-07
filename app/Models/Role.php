<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    //
    protected $fillable = [
        'nom',
        'status'
    ];

    public function user(){
        return $this->belongsToMany(User::class, 'role_user');
    }
}
