<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();

            // Website
            $table->string('site_name');
            $table->string('slogan')->nullable();
            $table->string('logo')->nullable();
            $table->string('favicon')->nullable();

            // Theme
            $table->string('primary_color')->default('#0d8fd8');
            $table->string('secondary_color')->default('#28a745');

            // Contact
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->text('address')->nullable();

            // Social
            $table->string('facebook')->nullable();
            $table->string('youtube')->nullable();
            $table->string('tiktok')->nullable();
            $table->string('instagram')->nullable();
            $table->string('zalo')->nullable();

            // Footer
            $table->text('footer_text')->nullable();
            $table->string('copyright')->nullable();

            // SEO
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();

            // Analytics
            $table->text('google_map')->nullable();
            $table->text('google_analytics')->nullable();

            $table->timestamps();
        });
    }
};
