<?php

namespace App\Models;

use App\Support\HasTranslatedFields;
use Illuminate\Database\Eloquent\Model;

class AboutContent extends Model
{
    use HasTranslatedFields;

    protected $table = 'about_content';

    protected $fillable = [
        'hero_title_en', 'hero_title_ar', 'hero_text_en', 'hero_text_ar',
        'who_we_are_p1_en', 'who_we_are_p1_ar', 'who_we_are_p2_en', 'who_we_are_p2_ar',
        'vision_en', 'vision_ar', 'mission_en', 'mission_ar',
        'commitment_en', 'commitment_ar', 'team_intro_en', 'team_intro_ar',
        'advisory_note_en', 'advisory_note_ar',
    ];

    public static function current(): self
    {
        return static::query()->firstOrCreate(['id' => 1]);
    }
}
