<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo Zapatilla
 * 
 * Representa la entidad zapatilla con relación a modelo y marca.
 */
class Zapatilla extends Model
{
    use HasFactory;

    // Definición de la tabla y campos rellenables
    protected $table = 'zapatillas';
    protected $fillable = ['modelo_id', 'sku', 'nombre', 'precio', 'imagen_url', 'descripcion', 'tendencia'];
    protected $casts = [
        'tendencia' => 'boolean',
        'precio' => 'decimal:2',
    ];

    // Relación con modelo
    public function modelo()
    {
        return $this->belongsTo(Modelo::class);
    }
}
