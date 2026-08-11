<?php

namespace App\Models;

use App\Support\HasTranslatedFields;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class TeamMember extends Model
{
    use HasTranslatedFields;

    protected $fillable = [
        'name_en', 'name_ar', 'credentials', 'role_en', 'role_ar', 'bio_en', 'bio_ar',
        'specialty_id', 'photo', 'is_leadership', 'order', 'is_active',
    ];

    protected $casts = [
        'is_leadership' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function specialty()
    {
        return $this->belongsTo(Specialty::class);
    }

    /**
     * Public URL for the uploaded photo, or null when there is none.
     *
     * The admin FileUpload stores a disk-relative path such as
     * "team/01KZ....jpg"; this resolves it against the public disk.
     */
    public function photoUrl(): ?string
    {
        if (blank($this->photo)) {
            return null;
        }

        return Storage::disk('public')->url($this->photo);
    }

    public function initials(): string
    {
        // Built from the displayed name, so an Arabic page shows Arabic initials.
        $name = $this->trans('name');

        if (blank($name)) {
            return '';
        }
        $parts = array_filter(explode(' ', str_replace(['Dr.', 'د.'], '', $name)));
        $letters = array_map(function ($part) {
            // Drop the Arabic definite article, otherwise every surname
            // starting with "ال" yields the same second initial.
            $part = preg_replace('/^ال(?=.)/u', '', $part);

            return mb_strtoupper(mb_substr($part, 0, 1));
        }, $parts);

        return implode('', array_slice($letters, 0, 2));
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('order');
    }

    public function scopeLeadership($query)
    {
        return $query->where('is_leadership', true);
    }

    public function scopeDirectory($query)
    {
        return $query->where('is_leadership', false);
    }
}
