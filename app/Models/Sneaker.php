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
        "color_es",
        "color_en",
        "description_es",
        "description_en",
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

    // Scope: búsqueda por nombre, SKU, color, descripción o marca
    public function scopeSearch($consulta, $termino)
    {
        return $consulta->where(function ($q) use ($termino) {
            $q->where("name", "like", "%{$termino}%")
                ->orWhere("sku", "like", "%{$termino}%")
                ->orWhere("color_es", "like", "%{$termino}%")
                ->orWhere("color_en", "like", "%{$termino}%")
                ->orWhere("description_es", "like", "%{$termino}%")
                ->orWhere("description_en", "like", "%{$termino}%")
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
        $normalizedColor = trim(mb_strtolower($color));

        // Buscar en ambos campos de color (español e inglés)
        return $consulta->where(function ($query) use ($normalizedColor) {
            $query->whereRaw('LOWER(color_es) = ?', [$normalizedColor])
                ->orWhereRaw('LOWER(color_en) = ?', [$normalizedColor]);
        });
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
        $locale = substr(app()->getLocale(), 0, 2);
        $localizedField = $locale === "en" ? "color_en" : "color_es";
        $localizedValue = $this->{$localizedField} ?? null;

        if ($localizedValue) {
            return $localizedValue;
        }

        // Si no hay valor localizado, intentar usar el campo de fallback del otro idioma
        $fallbackField = $locale === "en" ? "color_es" : "color_en";
        return $this->{$fallbackField} ?? '';
    }

    public function getTranslatedDescriptionAttribute()
    {
        $locale = substr(app()->getLocale(), 0, 2);

        if ($locale === "en" && $this->description_en) {
            return $this->description_en;
        }

        if ($locale === "es" && $this->description_es) {
            return $this->description_es;
        }

        return $this->description_en ?: $this->description_es ?: '';
    }

    // Obtener todos los colores únicos localizados según el idioma actual
    public static function getColors()
    {
        $locale = substr(app()->getLocale(), 0, 2);

        $sneakers = self::select('color_es', 'color_en')
            ->where(function ($query) {
                $query->whereNotNull('color_es')->where('color_es', '!=', '')
                    ->orWhereNotNull('color_en')->where('color_en', '!=', '');
            })
            ->get();

        $grupos = collect();

        foreach ($sneakers as $sneaker) {
            $colorEs = trim($sneaker->color_es ?? '');
            $colorEn = trim($sneaker->color_en ?? '');

            if ($colorEs === '' && $colorEn === '') {
                continue;
            }

            $key = mb_strtolower($colorEs) . '||' . mb_strtolower($colorEn);
            $canonical = $colorEn ?: $colorEs;

            if (!$grupos->has($key)) {
                $grupos->put($key, [
                    'es' => $colorEs,
                    'en' => $colorEn,
                    'value' => $canonical,
                    'sort' => mb_strtolower($canonical),
                ]);
            }
        }

        return $grupos->sortBy('sort')->map(function ($colores) use ($locale) {
            return [
                'value' => $colores['value'],
                'label' => $locale === 'en' ? ($colores['en'] ?: $colores['es']) : ($colores['es'] ?: $colores['en']),
            ];
        })->values();
    }

    // Traducir un color al idioma actual
    public static function translateColor($color)
    {
        $locale = substr(app()->getLocale(), 0, 2);

        $sneaker = self::where(function ($query) use ($color) {
            $query->where('color_es', $color)
                ->orWhere('color_en', $color);
        })->first();

        if (!$sneaker) {
            return $color;
        }

        if ($locale === 'es' && $sneaker->color_es) {
            return $sneaker->color_es;
        } elseif ($locale === 'en' && $sneaker->color_en) {
            return $sneaker->color_en;
        }

        return $sneaker->color_es ?: $sneaker->color_en ?: $color;
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