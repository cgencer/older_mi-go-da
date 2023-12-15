<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class FeatureGroups extends Model
{
    use HasTranslations;

    public array $translatable = ['name'];
    protected $table = 'feature_groups';

    public function features()
    {
        return $this->hasMany('App\Models\Features', 'group_id');
    }

    public function category()
    {
        return $this->belongsTo('App\Models\FeatureCategories', 'category_id');
    }
}
