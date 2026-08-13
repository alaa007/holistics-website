<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->text('map_embed_src')->nullable()->after('map_query');
        });

        DB::table('settings')->whereNull('map_embed_src')->update([
            'map_embed_src' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d6933099.635232275!2d26.144584625!3d31.952687700000023!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x151ca1e1c2ec3fdd%3A0x2a19318336c749d5!2sHOLISTICS!5e0!3m2!1sen!2sae!4v1786615744410!5m2!1sen!2sae',
        ]);
    }

    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn('map_embed_src');
        });
    }
};
