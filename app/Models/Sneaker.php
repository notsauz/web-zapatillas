<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;

class Sneaker extends Model
{
    use HasFactory;

    // Nombre de la tabla
    protected $table = "sneakers";

    // Campos que se pueden asignar masivamente
    protected $fillable = [
        "name",
        "sku",
        "brand_id",
        "category",
        "price",
        "image_url",
        "sizes",
        "color",
        "description",
    ];

    // Conversión de tipos de datos
    protected $casts = [
        "price" => "decimal:2",
        "sizes" => "array",
    ];

    // Relación: zapatilla pertenece a una marca
    public function brandModel(): BelongsTo
    {
        return $this->belongsTo(Brand::class, "brand_id");
    }

    // Obtener el nombre de la marca
    public function getBrandAttribute()
    {
        return $this->brandModel?->name;
    }

    // Scope: filtrar por categoría
    public function scopeByCategory($consulta, $categoria)
    {
        return $consulta->where("category", $categoria);
    }

    // Scope: filtrar por marca
    public function scopeByBrand($consulta, $marca)
    {
        return $consulta->whereHas("brandModel", function ($subConsulta) use ($marca) {
            $subConsulta->where("name", $marca);
        });
    }

    // Scope: búsqueda por nombre, SKU, color o marca
    public function scopeSearch($consulta, $termino)
    {
        return $consulta->where(function ($q) use ($termino) {
            $q->where("name", "like", "%{$termino}%")
                ->orWhere("sku", "like", "%{$termino}%")
                ->orWhere("color", "like", "%{$termino}%")
                ->orWhereHas("brandModel", function ($subQ) use ($termino) {
                    $subQ->where("name", "like", "%{$termino}%");
                });
        });
    }

    // Scope: filtrar por rango de precio
    public function scopePriceRange($consulta, $precioMin, $precioMax)
    {
        if ($precioMin !== null && $precioMax !== null) {
            return $consulta->whereBetween("price", [$precioMin, $precioMax]);
        } elseif ($precioMin !== null) {
            return $consulta->where("price", ">=", $precioMin);
        } elseif ($precioMax !== null) {
            return $consulta->where("price", "<=", $precioMax);
        }
        return $consulta;
    }

    // Scope: filtrar por color
    public function scopeByColor($consulta, $color)
    {
        return $consulta->where("color", $color);
    }

    // Scope: filtrar por talla
    public function scopeBySize($consulta, $talla)
    {
        return $consulta->whereJsonContains("sizes", $talla);
    }

    // Obtener todas las marcas únicas
    public static function getBrands()
    {
        return Brand::select("name")->orderBy("name")->pluck("name");
    }

    // Traducir etiquetas compuestas como colores y textos creados en la base de datos
    public static function translateLabel(?string $text): ?string
    {
        if (!$text) {
            return $text;
        }

        $parts = preg_split('/(\/|,)/u', $text, -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);

        return collect($parts)
            ->map(function ($part) {
                if ($part === '/' || $part === ',') {
                    return $part;
                }

                return __($part);
            })
            ->implode('');
    }

    public function getTranslatedColorAttribute()
    {
        return self::translateLabel($this->color);
    }

    // Obtener todos los colores únicos
    public static function getColors()
    {
        return self::select("color")->distinct()->whereNotNull("color")->pluck("color")->sort();
    }

    // Obtener todas las tallas disponibles
    public static function getAvailableSizes()
    {
        $zapatillas = self::all();
        $tallas = collect();

        foreach ($zapatillas as $zapatilla) {
            if ($zapatilla->sizes) {
                $tallas = $tallas->merge($zapatilla->sizes);
            }
        }

        return $tallas->unique()->sort()->values();
    }

    // Relación: usuarios que tienen esta zapatilla como favorita
    public function favoritedByUsers()
    {
        return $this->belongsToMany(User::class, "favorites")->withTimestamps();
    }

    // Obtener el número de favoritos de esta zapatilla
    public function getFavoritesCountAttribute()
    {
        return $this->favoritedByUsers()->count();
    }

    // Scope: ordenar por número de favoritos (más favoritos primero)
    public function scopeMostFavorited($consulta)
    {
        return $consulta->withCount("favoritedByUsers")
            ->orderBy("favorited_by_users_count", "desc");
    }
}