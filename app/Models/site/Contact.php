<?php

namespace App\Models\site;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;
    
    protected $table = 'contacts';
    protected $fillable = ['name', 'email', 'phone', 'message'];
}
