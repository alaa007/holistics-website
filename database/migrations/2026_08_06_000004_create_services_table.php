<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('icon')->default('heart');
            $table->string('title_en');
            $table->string('title_ar')->nullable();
            $table->string('short_en');
            $table->string('short_ar')->nullable();
            $table->text('overview_en');
            $table->text('overview_ar')->nullable();
            $table->text('included_en')->nullable();
            $table->text('included_ar')->nullable();
            $table->text('who_en')->nullable();
            $table->text('who_ar')->nullable();
            $table->unsignedInteger('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
