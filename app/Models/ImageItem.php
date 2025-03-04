<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImageItem extends Model
{
    use HasFactory;
    protected $table = 'image_items';
    protected $fillable = [
        'url',
        'original_name',
        'table_name',
        'table_id',
        'type',
        'status',
        'token'
    ];

    public function table() {
        return $this->morphTo('table_name', 'table_id');
    }
}
