<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * The title suffix has to exist per locale: an Arabic title ends in
     * "هوليستكس", so a Latin "Holistics" suffix would be appended on top of a
     * brand name that is already there.
     */
    public function up(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->renameColumn('seo_title_suffix', 'seo_title_suffix_en');
        });

        Schema::table('settings', function (Blueprint $table) {
            $table->string('seo_title_suffix_ar')->nullable()->after('seo_title_suffix_en');
        });
    }

    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn('seo_title_suffix_ar');
        });

        Schema::table('settings', function (Blueprint $table) {
            $table->renameColumn('seo_title_suffix_en', 'seo_title_suffix');
        });
    }
};
