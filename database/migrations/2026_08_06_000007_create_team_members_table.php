<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('team_members', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('credentials')->nullable();
            $table->string('role_en');
            $table->string('role_ar')->nullable();
            $table->text('bio_en');
            $table->text('bio_ar')->nullable();
            $table->string('specialty');
            $table->string('specialty_label_en');
            $table->string('specialty_label_ar')->nullable();
            $table->string('photo')->nullable();
            $table->boolean('is_leadership')->default(false);
            $table->boolean('is_placeholder')->default(true);
            $table->unsignedInteger('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('team_members');
    }
};
