<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('home_slides', function (Blueprint $table) {
            $table->id();
            $table->string('eyebrow_en');
            $table->string('eyebrow_ar')->nullable();
            $table->string('heading_prefix_en')->nullable();
            $table->string('heading_prefix_ar')->nullable();
            $table->string('heading_highlight_en');
            $table->string('heading_highlight_ar')->nullable();
            $table->text('text_en');
            $table->text('text_ar')->nullable();
            $table->string('cta1_label_en')->nullable();
            $table->string('cta1_label_ar')->nullable();
            $table->string('cta1_url')->nullable();
            $table->string('cta2_label_en')->nullable();
            $table->string('cta2_label_ar')->nullable();
            $table->string('cta2_url')->nullable();
            $table->unsignedInteger('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('home_slides');
    }
};
