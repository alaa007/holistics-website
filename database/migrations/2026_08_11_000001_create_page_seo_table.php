<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('page_seo', function (Blueprint $table) {
            $table->id();
            // Matches Route::currentRouteName() so the resolver needs no mapping table.
            $table->string('route_name')->unique();
            $table->string('label');
            $table->string('meta_title_en')->nullable();
            $table->string('meta_title_ar')->nullable();
            $table->text('meta_description_en')->nullable();
            $table->text('meta_description_ar')->nullable();
            $table->string('og_image')->nullable();
            $table->boolean('noindex')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('page_seo');
    }
};
