<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Brand extends Model
{
    // Campos que se pueden asignar masivamente
    protected $fillable = ["name", "description_es", "description_en", "logo_url"];

    // Relación: una marca tiene muchas zapatillas
    public function sneakers(): HasMany
    {
        return $this->hasMany(Sneaker::class);
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
}