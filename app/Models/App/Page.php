<?php

namespace App\Models\App;

use App\Models\Translation;
use App\Traits\LanguageTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model {

    use HasFactory , LanguageTrait;
    protected $primaryKey = 'id';

    public $fillable = [
    'meta',
    'section_id' ,
    'tr_token',
    'name',
    'description',
    'image',
    'status',
    'type',
    'created_at',
    'updated_at',
    ];
    
    public static function txt()
    {
        return [
            'meta' => [
                'label' => 'meta',
                'type' => 'input', 
                'data_type' => 'string', 
                'icon' => 'fa fa-text-width', 
            ],
            'name' => [
                'label' => 'Name Section',
                'type' => 'input', 
                'data_type' => 'string', 
                'icon' => 'fa fa-text-width', 
            ],

            'description' => [
                'label' => 'description',
                'type' => 'textarea', 
                'data_type' => 'string', 
                'icon' => 'fa fa-align-left', 
            ],
            
        ];
    }



    public function translations()
    {
        return $this->morphMany(Translation::class, 'translatable');
    }

    public function language()
    {
        return $this->belongsTo(Translation::class, 'token', 'tr_token');
    }

}
