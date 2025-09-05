<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAwardCategoriesTable extends Migration
{
    public function up()
    {
        Schema::create('award_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');

            // country_id must be nullable if you use onDelete('set null')
            $table->unsignedBigInteger('country_id')->nullable();
            // Category relationships
            $table->unsignedBigInteger('main_category_id');
            $table->unsignedBigInteger('sub_category_id');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('award_categories');
    }
}
