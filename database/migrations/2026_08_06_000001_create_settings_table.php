<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('brand_name')->default('HOLISTICS');
            $table->string('tagline_en')->default('Healing the whole you');
            $table->string('tagline_ar')->nullable();
            $table->string('whatsapp_number')->default('962781818211');
            $table->string('phone_display')->default('+962 78 181 8211');
            $table->string('phone_href')->default('tel:+962781818211');
            $table->string('email')->default('info@holistics-care.com');
            $table->string('address_en')->default('Al-Dawha Medical Complex, Amman, Jordan');
            $table->string('address_ar')->nullable();
            $table->string('map_query')->default('Al-Dawha+Medical+Complex+Amman+Jordan');
            $table->text('footer_about_en')->nullable();
            $table->text('footer_about_ar')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
