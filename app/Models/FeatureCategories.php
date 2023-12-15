<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class FeatureCategories extends Model
{
    use HasTranslations;

    public $translatable = ['name'];
    protected $table = 'feature_categories';

    public function groups()
    {
        return $this->hasMany('App\Models\FeatureGroups', 'category_id', 'id');
    }
}
