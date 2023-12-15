<?php

namespace App\Models;

use Emadadly\LaravelUuid\Uuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use Spatie\Sluggable\HasTranslatableSlug;
use Spatie\Sluggable\SlugOptions;
use Spatie\Translatable\HasTranslations;

class HotelCategories extends Model
{
    use HasTranslations, HasTranslatableSlug, Uuids;

    public $translatable = ['name', 'slug'];
    protected $table = 'hotel_categories';

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    public function getCategoryBgWebPath()
    {
        return '' === $this->bg_filename ? null : asset($this->bg_filename);
    }

    public function getCategoryWhiteIconWebPath()
    {
        return '' === $this->filename ? null : asset($this->filename);
    }

    public function getCategoryRedIconWebPath()
    {
        return '' === $this->filename_red ? null : asset($this->filename_red);
    }
}
