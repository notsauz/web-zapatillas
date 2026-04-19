<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Brand extends Model
{
    // Definir el nombre de la tabla
    protected $fillable = ['name', 'description', 'logo_url'];

    // Relación con las zapatillas
    public function sneakers(): HasMany
    {
        return $this->hasMany(Sneaker::class);
    }
}
