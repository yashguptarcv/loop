<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique(); // e.g. "about", "destination"
            $table->string('title'); // Page title
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('meta_keywords')->nullable();
            $table->text('meta_og_image')->nullable(); // for social sharing
            $table->string('view')->default('shop.page'); // blade file
            $table->longText('content')->nullable(); // if you want CMS like content
            $table->string('status', 11)->nullable(); // if you want CMS like content
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pages');
    }
};
