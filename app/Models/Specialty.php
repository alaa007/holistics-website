<?php

namespace App\Models;

use App\Support\HasTranslatedFields;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Specialty extends Model
{
    use HasTranslatedFields;

    protected $fillable = ['slug', 'label_en', 'label_ar', 'order'];

    protected static function booted(): void
    {
        static::saving(function (Specialty $specialty) {
            if (filled($specialty->slug)) {
                return;
            }

            $base = Str::slug($specialty->label_en);
            $slug = $base;
            $suffix = 2;

            while (static::where('slug', $slug)->where('id', '!=', $specialty->id)->exists()) {
                $slug = "{$base}-{$suffix}";
                $suffix++;
            }

            $specialty->slug = $slug;
        });
    }

    public function teamMembers()
    {
        return $this->hasMany(TeamMember::class);
    }
}
