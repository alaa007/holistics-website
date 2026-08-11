<?php

namespace App\Models;

use App\Support\HasTranslatedFields;
use Illuminate\Database\Eloquent\Model;

class PageSeo extends Model
{
    use HasTranslatedFields;

    protected $table = 'page_seo';

    protected $fillable = [
        'route_name', 'label',
        'meta_title_en', 'meta_title_ar',
        'meta_description_en', 'meta_description_ar',
        'og_image', 'noindex',
    ];

    protected $casts = ['noindex' => 'boolean'];

    public static function forRoute(?string $routeName): ?self
    {
        if (blank($routeName)) {
            return null;
        }

        return static::query()->where('route_name', $routeName)->first();
    }
}
