<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('services', function (Blueprint $table) {
            // All nullable: the resolver falls back to title_* / short_* when blank,
            // so an untouched service still gets sensible meta tags.
            $table->string('meta_title_en')->nullable()->after('who_ar');
            $table->string('meta_title_ar')->nullable()->after('meta_title_en');
            $table->text('meta_description_en')->nullable()->after('meta_title_ar');
            $table->text('meta_description_ar')->nullable()->after('meta_description_en');
            $table->string('og_image')->nullable()->after('meta_description_ar');
        });
    }

    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->dropColumn([
                'meta_title_en', 'meta_title_ar',
                'meta_description_en', 'meta_description_ar',
                'og_image',
            ]);
        });
    }
};
