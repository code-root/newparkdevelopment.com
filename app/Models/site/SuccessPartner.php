<?php

namespace App\Models\site;

use App\Models\Translation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuccessPartner extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    protected $fillable = [
            'name',
            'logo',
    ];


}
