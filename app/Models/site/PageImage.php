<?php

namespace App\Models\site;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PageImage extends Model
{
    use HasFactory;
    protected $fillable = ['page_id', 'image'];

    public function page()
    {
        return $this->belongsTo(Page::class);
    }
}
