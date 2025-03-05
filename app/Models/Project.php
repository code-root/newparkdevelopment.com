<?php

namespace App\Models;

use App\Models\site\Category;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    protected $table = 'projects';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'title',
        'description',
        'price',
        'image',
        'category_id',
        'status',
        'tr_token'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'status' => 'string',
    ];

    /**
     * Get the category associated with the project.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function category()
    {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }

    /**
     * Get the translation language associated with the project.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function language()
    {
        return $this->belongsTo(Translation::class, 'token', 'tr_token');
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
                'label' => 'Project Name',
                'type' => 'input',
                'data_type' => 'string',
                'icon' => 'fa fa-text-width',
            ],
            'title' => [
                'label' => 'Project Address',
                'type' => 'input',
                'data_type' => 'string',
                'icon' => 'fa fa-language',
            ],
            'description' => [
                'label' => 'Project Description',
                'type' => 'textarea',
                'data_type' => 'string',
                'icon' => 'fa fa-align-left',
            ],
            // 'price' => [
            //     'label' => 'سعر الخدمة',
            //     'type' => 'input',
            //     'data_type' => 'decimal',
            //     'icon' => 'fa fa-dollar-sign',
            // ],
        ];
    }
    public function images()
    {
        return $this->hasMany(ServiceImage::class);
    }
    /**
     * Get the translations for the project.
     */
    public function translations()
    {
        return $this->morphMany(Translation::class, 'translatable');
    }

        public function orders()
    {
        return $this->hasMany(ServiceOrder::class);
    }

    public function views()
    {
        return $this->hasMany(ServiceView::class);
    }
}
