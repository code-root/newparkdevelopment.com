<?php

namespace App\Models\site;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Page extends Model {

    protected $primaryKey = 'id';
    use HasFactory;

    public $fillable = [
        'meta',
        'description',
        'name',
        'type' ,
        'slug',
        'meta_title',
        'meta_description',
        'status',
    ];

    public function images()
{
    return $this->hasMany(PageImage::class);
}


}
