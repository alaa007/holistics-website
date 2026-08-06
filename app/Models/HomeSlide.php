<?php

namespace App\Models;

use App\Support\HasTranslatedFields;
use Illuminate\Database\Eloquent\Model;

class HomeSlide extends Model
{
    use HasTranslatedFields;

    protected $fillable = [
        'eyebrow_en', 'eyebrow_ar',
        'heading_prefix_en', 'heading_prefix_ar',
        'heading_highlight_en', 'heading_highlight_ar',
        'text_en', 'text_ar',
        'cta1_label_en', 'cta1_label_ar', 'cta1_url',
        'cta2_label_en', 'cta2_label_ar', 'cta2_url',
        'order', 'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('order');
    }
}
