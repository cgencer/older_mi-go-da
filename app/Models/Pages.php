<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;
use Plank\Mediable\Mediable;
use Spatie\Translatable\HasTranslations;

class Pages extends Model
{
    use HasTranslations, Mediable;

    public $translatable = ['title', 'slug', 'content'];
    protected $table = 'pages';
}
