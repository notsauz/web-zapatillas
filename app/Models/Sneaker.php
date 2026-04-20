<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;

class Sneaker extends Model
{
    use HasFactory;

    // Definir el nombre de la tabla
    protected $table = 'sneakers';

    // Definir los campos que se pueden asignar masivamente
    protected $fillable = [
        'name',
        'sku',
        'brand_id',
        'category',
        'price',
        'image_url',
        'sizes',
        'color',
        'description',
    ];

    // Definir los campos que deben ser convertidos a tipos específicos
    protected $casts = [
        'price' => 'decimal:2',
        'sizes' => 'array',
    ];

    // Relación con la marca
    public function brandModel(): BelongsTo
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    // Obtener el nombre de la marca a través de la relación
    public function getBrandAttribute()
    {
        return $this->brandModel?->name;
    }

    /**
     * Scope para filtrar por categoría
     */
    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    /**
     * Scope para filtrar por marca
     */
    public function scopeByBrand($query, $brand)
    {
        return $query->whereHas('brandModel', function ($subQuery) use ($brand) {
            $subQuery->where('name', $brand);
        });
    }

    /**
     * Scope para búsqueda por nombre, SKU o marca
     */
    public function scopeSearch($query, $term)
    {
        //
        return $query->where(function ($q) use ($term) {
            $q->where('name', 'like', "%{$term}%")
                ->orWhere('sku', 'like', "%{$term}%")
                ->orWhere('color', 'like', "%{$term}%")
                ->orWhereHas('brandModel', function ($subQ) use ($term) {
                    $subQ->where('name', 'like', "%{$term}%");
                });
        });
    }

    /**
     * Scope para filtrar por rango de precio
     */
    public function scopePriceRange($query, $minPrice, $maxPrice)
    {
        return $query->whereBetween('price', [$minPrice, $maxPrice]);
    }

    /**
     * Scope para filtrar por color
     */
    public function scopeByColor($query, $color)
    {
        return $query->where('color', $color);
    }

    /**
     * Scope para filtrar por talla
     */
    public function scopeBySize($query, $size)
    {
        return $query->whereJsonContains('sizes', $size);
    }

    /**
     * Obtener todas las marcas únicas
     */
    public static function getBrands()
    {
        return Brand::select('name')->orderBy('name')->pluck('name');
    }

    /**
     * Obtener todos los colores únicos
     */
    public static function getColors()
    {
        return self::select('color')->distinct()->whereNotNull('color')->pluck('color')->sort();
    }

    /**
     * Obtener todas las tallas disponibles
     */
    public static function getAvailableSizes()
    {
        $sneakers = self::all();
        $sizes = collect();

        foreach ($sneakers as $sneaker) {
            if ($sneaker->sizes) {
                $sizes = $sizes->merge($sneaker->sizes);
            }
        }

        return $sizes->unique()->sort()->values();
    }

    /**
     * Relación con usuarios que tienen esta zapatilla como favorita
     */
    public function favoritedByUsers()
    {
        return $this->belongsToMany(User::class, 'favorites')->withTimestamps();
    }
}
