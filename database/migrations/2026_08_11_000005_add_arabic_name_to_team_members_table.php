<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Renames name to name_en so it forms a translated pair with the new
     * name_ar, the same shape as role_en/role_ar and bio_en/bio_ar. That
     * lets HasTranslatedFields::trans('name') resolve it with no special
     * casing, including the fallback to English when no Arabic name is set.
     */
    public function up(): void
    {
        Schema::table('team_members', function (Blueprint $table) {
            $table->renameColumn('name', 'name_en');
        });

        Schema::table('team_members', function (Blueprint $table) {
            $table->string('name_ar')->nullable()->after('name_en');
        });
    }

    public function down(): void
    {
        Schema::table('team_members', function (Blueprint $table) {
            $table->dropColumn('name_ar');
        });

        Schema::table('team_members', function (Blueprint $table) {
            $table->renameColumn('name_en', 'name');
        });
    }
};
