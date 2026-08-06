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
    ];

    public static function current(): self
    {
        return static::query()->firstOrCreate(['id' => 1]);
    }
}
