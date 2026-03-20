<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Modelo extends Model
{
    use HasFactory;

    // Definición de la tabla y campos rellenables
    protected $table = 'modelos';
    protected $fillable = ['marca_id', 'nombre'];

    // Relación con marca
    public function marca()
    {
        return $this->belongsTo(Marca::class);
    }

    // Relación con zapatillas
    public function zapatillas()
    {
        return $this->hasMany(Zapatilla::class);
    }
}
