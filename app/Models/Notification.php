<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'user_id',
        'message',
        'read'
    ];

    public function toArray(){
        return [
            "id"=>$this->id,
            'uid'=>$this->user_id,
            "message"=>$this->message,
            "read"=>$this->read,
            "created_at"=>$this->created_at
        ];
    }
}
