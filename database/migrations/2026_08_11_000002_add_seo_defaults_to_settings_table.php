<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->string('seo_title_en')->nullable()->after('map_query');
            $table->string('seo_title_ar')->nullable()->after('seo_title_en');
            $table->text('seo_description_en')->nullable()->after('seo_title_ar');
            $table->text('seo_description_ar')->nullable()->after('seo_description_en');
            // Appended to a page title as "Page — Suffix" when the page sets no title of its own.
            $table->string('seo_title_suffix')->nullable()->after('seo_description_ar');
            $table->string('og_image')->nullable()->after('seo_title_suffix');
        });
    }

    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn([
                'seo_title_en', 'seo_title_ar',
                'seo_description_en', 'seo_description_ar',
                'seo_title_suffix', 'og_image',
            ]);
        });
    }
};
