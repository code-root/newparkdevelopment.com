<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Translation extends Model
{
    use HasFactory;

    protected $fillable = [
        'token',
        'language_id',
        'key',
        'translatable_id' ,
        'translatable_type',
        'value',
        'status',
    ];

    /**
     * Get the language associated with the translation.
     */
    public function language()
    {
        return $this->belongsTo(Language::class);
    }

    /**
     * Get the owning translatable model.
     */
    public function translatable()
    {
        return $this->morphTo();
    }

    /**
     * Generate a unique token of 6 characters.
     *
     * @return string
     */

    public static function generateUniqueToken()
    {
        do {
            $token = strtoupper(substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 6));
        } while (self::where('token', $token)->exists());

        return $token;
    }
}