<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('team_members', function (Blueprint $table) {
            $table->foreignId('specialty_id')->nullable()->after('credentials')
                ->constrained()->nullOnDelete();
        });

        Schema::table('team_members', function (Blueprint $table) {
            $table->dropColumn(['specialty', 'specialty_label_en', 'specialty_label_ar', 'is_placeholder']);
        });
    }

    public function down(): void
    {
        Schema::table('team_members', function (Blueprint $table) {
            $table->dropConstrainedForeignId('specialty_id');
            $table->string('specialty')->nullable();
            $table->string('specialty_label_en')->nullable();
            $table->string('specialty_label_ar')->nullable();
            $table->boolean('is_placeholder')->default(true);
        });
    }
};
