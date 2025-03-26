<?php

namespace App\Models\Blog;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
        'title',
        'description',
        'author',
        'image',
        'status',
        'category_id',
    ];

    public function images()
    {
        return $this->hasMany(BlogImage::class);
    }

}
