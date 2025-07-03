<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Enum\UserStatus;
use App\Enum\UserType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email',
        'password',
        'status',
        'photo',
        'type',
    ];

    protected $casts = [
        'status' => UserStatus::class,
        'type' => UserType::class
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];


     /** Clé primaire = string + pas d’auto-increment */
    public $incrementing = false;
    protected $keyType   = 'string';

    /**
     * Génère l’UUID avant l’insertion si besoin.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            // Si l’id n’est pas déjà fixé, on le crée
            if (! $model->getKey()) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
                // ou Str::orderedUuid() si tu préfères des UUID V7 ordonnées
            }
        });
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }


    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_admin', 'user_id', 'role_id');
    }

    public function zones()
    {
        return $this->hasMany(Zone::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class, 'user_id', 'id');
    }

    public function profile()
    {
        return $this->hasOne(Profil::class, 'user_id', 'id');
    }
    public function livreur()
    {
        return $this->hasOne(Livreur::class, 'user_id', 'id');
    }

}
