<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\App\Page;

class Section extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'sections';

    protected $fillable = ['name_ar', 'name_en', 'slug', 'description_ar', 'description_en', 'image'];


    public function pages()
    {
        return $this->hasMany(Page::class, 'section_id' ,'id');
    }

}
