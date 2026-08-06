<?php

namespace App\Models;

use App\Support\HasTranslatedFields;
use Illuminate\Database\Eloquent\Model;

class ValueItem extends Model
{
    use HasTranslatedFields;

    protected $table = 'values';

    protected $fillable = ['icon', 'title_en', 'title_ar', 'text_en', 'text_ar', 'order', 'is_active'];

    protected $casts = ['is_active' => 'boolean'];

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('order');
    }
}
