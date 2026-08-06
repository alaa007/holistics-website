<?php

namespace App\Models;

use App\Support\HasTranslatedFields;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Service extends Model
{
    use HasTranslatedFields;

    protected $fillable = [
        'slug', 'icon', 'title_en', 'title_ar', 'short_en', 'short_ar',
        'overview_en', 'overview_ar', 'included_en', 'included_ar',
        'who_en', 'who_ar', 'order', 'is_active',
    ];

    protected $casts = ['is_active' => 'boolean'];

    protected static function booted(): void
    {
        static::saving(function (Service $service) {
            if (filled($service->slug)) {
                return;
            }

            $base = Str::slug($service->title_en);
            $slug = $base;
            $suffix = 2;

            while (static::where('slug', $slug)->where('id', '!=', $service->id)->exists()) {
                $slug = "{$base}-{$suffix}";
                $suffix++;
            }

            $service->slug = $slug;
        });
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('order');
    }
}
