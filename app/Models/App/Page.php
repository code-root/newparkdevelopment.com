<?php

namespace App\Models\App;

use App\Traits\LanguageTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Section; //
class Page extends Model {

    protected $primaryKey = 'id';
    use HasFactory, LanguageTrait;

    public $fillable = [
        'meta_ar',
        'meta_en',
        'name_ar',
        'name_en',
        'status',
        'description_ar',
        'description_en',
    ];

    public function section()
    {
        return $this->belongsTo(Section::class, 'section_id');
    }
}
