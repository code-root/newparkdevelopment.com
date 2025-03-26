<?php

namespace App\Models\site;

use App\Traits\LanguageTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Page extends Model {

    protected $primaryKey = 'id';
    use HasFactory, LanguageTrait;

    public $fillable = [
        'meta',
        'description',
        'name',
        'status',
    ];

}
