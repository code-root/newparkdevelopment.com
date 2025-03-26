<?php

namespace App\Models\blog;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogImage extends Model
{
    use HasFactory;
    protected $fillable = [
        'blog_id',
        'path',
    ];


    public function blog()
    {
        return $this->belongsTo(Blog::class);
    }
}
