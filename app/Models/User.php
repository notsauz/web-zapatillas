<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Sneaker;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // Campos que se pueden asignar masivamente
    protected $fillable = [
        "name",
        "username",
        "email",
        "email_verified_at",
        "password",
    ];

    // Campos ocultos en arrays/JSON
    protected $hidden = [
        "password",
        "remember_token",
    ];

    // Conversión de tipos de datos
    protected function casts(): array
    {
        return [
            "email_verified_at" => "datetime",
            "password" => "hashed",
        ];
    }

    // Relación: zapatillas favoritas del usuario
    public function favoriteSneakers()
    {
        return $this->belongsToMany(Sneaker::class, "favorites")->withTimestamps();
    }
}