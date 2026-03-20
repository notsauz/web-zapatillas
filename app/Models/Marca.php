<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Marca extends Model
{
    use HasFactory;

    // Definición de la tabla y campos rellenables
    protected $table = 'marcas';
    protected $fillable = ['nombre'];

    // Relación con modelos
    public function modelos()
    {
        return $this->hasMany(Modelo::class);
    }
}
