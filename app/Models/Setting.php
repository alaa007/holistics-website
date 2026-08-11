<?php

namespace App\Models;

use App\Support\HasTranslatedFields;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasTranslatedFields;

    protected $fillable = [
        'brand_name', 'tagline_en', 'tagline_ar',
        'whatsapp_number', 'phone_display', 'phone_href', 'email',
        'address_en', 'address_ar', 'map_query',
        'footer_about_en', 'footer_about_ar',
        'seo_title_en', 'seo_title_ar',
        'seo_description_en', 'seo_description_ar',
        'seo_title_suffix_en', 'seo_title_suffix_ar', 'og_image',
    ];

    public static function current(): self
    {
        return static::query()->firstOrCreate(['id' => 1]);
    }
}
