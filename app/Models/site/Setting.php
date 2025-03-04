<?php

namespace App\Models\site;

use App\Models\Language;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'language_id',
        'type',
        'value',
        'page',
        'slug',
    ];

    public function language()
    {
        return $this->hasOne(Language::class, 'id', 'language_id');
    }
}
