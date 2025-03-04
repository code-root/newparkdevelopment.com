<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'title',
        'description',
        'author',
        'image',
        'tr_token',
        'status',
        
    ];

      /**
     * Get the translations for the service.
     */
    public function translations()
    {
        return $this->morphMany(Translation::class, 'translatable');
    }

    /**
     * Returns an array of key/value pairs, where each key is a field name
     * and each value is an array that contains the field's label, type, data type, and icon.
     *
     * The array is used to generate input fields in the admin panel.
     *
     * @return array
     */
    public static function txt()
    {
        return [
            'name' => [
                'label' => 'name',
                'type' => 'input',
                'data_type' => 'string',
                'icon' => 'fa fa-text-width',
            ],
            'title' => [
                'label' => 'Title',
                'type' => 'input',
                'data_type' => 'string',
                'icon' => 'fa fa-text-width',
            ],
            'description' => [
                'label' => 'Content',
                'type' => 'textarea',
                'data_type' => 'text',
                'icon' => 'fa fa-align-left',
            ],
            // 'author' => [
            //     'label' => 'Author',
            //     'type' => 'input',
            //     'data_type' => 'string',
            //     'icon' => 'fa fa-user',
            // ],
            // 'image' => [
            //     'label' => 'Image',
            //     'type' => 'file',
            //     'data_type' => 'string',
            //     'icon' => 'fa fa-image',
            // ],
        ];
    }
}
