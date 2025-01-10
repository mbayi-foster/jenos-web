<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Zone extends Model
{
    //
    protected $fillable = [
        'nom',
        'status',
        'chef',
    ];

    public function chefs(){
        return $this->belongsTo(User::class, 'chef');
    }
}
