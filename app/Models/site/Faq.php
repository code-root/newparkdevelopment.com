<?php

namespace App\Models\site;

use App\Models\Translation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    use HasFactory;

    protected $fillable = [
        'question',
        'answer',
        'tr_token',
    ];

    // Get the language associated with the subject. */
   public function language()
   {
       return $this->belongsTo(Translation::class, 'token', 'tr_token');
   }

   public static function txt()
   {
       return [
           'question' => [
               'label' => 'The question',
               'type' => 'input',
               'data_type' => 'string',
               'icon' => 'fa fa-text-width',
           ],

           'answer' => [
               'label' => 'The answer',
               'type' => 'input',
               'data_type' => 'string',
               'icon' => 'fa fa-language',
           ],


       ];
   }

   public function translations()
   {
       return $this->morphMany(Translation::class, 'translatable');
   }



}
