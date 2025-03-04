<?php

namespace App\Models;

use App\Models\site\Slider;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'is_active',
        'is_default',
        'direction',
        'flag',
        'currency',
        'currency_symbol',
        'locale',
        'date_format',
        'time_format',
        'timezone',
        'weekend',
        'status',
    ];

    /**
     * Get the translations for the language.
     */
    public function translations()
    {
        return $this->hasMany(Translation::class);
    }

    /**
     * Get the sliders for the language.
     */
    public function sliders()
    {
        return $this->hasMany(Slider::class);
    }
}


