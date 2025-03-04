<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProjectRequest;
class Offer extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'discount', 'price', 'description', 'image', 'status'];

    /**
     * علاقة العروض مع طلبات المشاريع (Project Requests)
     */
    public function projectRequests()
    {
        return $this->hasMany(ProjectRequest::class, 'offer_id');
    }
    
}
