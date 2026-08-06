<?php

namespace App\Models;

use App\Support\HasTranslatedFields;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasTranslatedFields;

    protected $fillable = [
        'slug', 'icon', 'title_en', 'title_ar', 'short_en', 'short_ar',
        'overview_en', 'overview_ar', 'included_en', 'included_ar',
        'who_en', 'who_ar', 'order', 'is_active',
    ];

    protected $casts = ['is_active' => 'boolean'];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('order');
    }
}
