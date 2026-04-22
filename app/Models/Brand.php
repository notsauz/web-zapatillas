<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Brand extends Model
{
    // Campos que se pueden asignar masivamente
    protected $fillable = ["name", "description", "logo_url"];

    // Relación: una marca tiene muchas zapatillas
    public function sneakers(): HasMany
    {
        return $this->hasMany(Sneaker::class);
    }
}