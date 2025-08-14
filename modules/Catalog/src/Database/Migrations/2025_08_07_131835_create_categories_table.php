<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id('id');
            $table->unsignedBigInteger('parent_id')->nullable()->index()->comment('Parent category for subcategories');
            $table->string('name');
            $table->string('slug')->unique()->comment('SEO-friendly URL key');
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->enum('status', ['A', 'D'])->default('A')->comment('A=Active, D=Disabled');
            $table->unsignedInteger('position')->default(0)->comment('Sorting order within parent');
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->timestamps();

            // Optional: if you want cascading delete
            // $table->foreign('parent_id')->references('id')->on('categories')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
