<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('about_content', function (Blueprint $table) {
            $table->id();
            $table->string('hero_title_en')->nullable();
            $table->string('hero_title_ar')->nullable();
            $table->text('hero_text_en')->nullable();
            $table->text('hero_text_ar')->nullable();
            $table->text('who_we_are_p1_en')->nullable();
            $table->text('who_we_are_p1_ar')->nullable();
            $table->text('who_we_are_p2_en')->nullable();
            $table->text('who_we_are_p2_ar')->nullable();
            $table->text('vision_en')->nullable();
            $table->text('vision_ar')->nullable();
            $table->text('mission_en')->nullable();
            $table->text('mission_ar')->nullable();
            $table->text('commitment_en')->nullable();
            $table->text('commitment_ar')->nullable();
            $table->text('team_intro_en')->nullable();
            $table->text('team_intro_ar')->nullable();
            $table->text('advisory_note_en')->nullable();
            $table->text('advisory_note_ar')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('about_content');
    }
};
