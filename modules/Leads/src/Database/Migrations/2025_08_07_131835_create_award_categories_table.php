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

            // Either use this shorthand (recommended):
            $table->foreignId('country_id')->constrained('countries');

            // // OR explicitly define the relationship like this:
            
            // $table->foreign('country_id')
            //     ->references('id')
            //     ->on('countries');

            // Category relationships
            $table->unsignedBigInteger('main_category_id');
            $table->unsignedBigInteger('sub_category_id');

            $table->foreign('main_category_id')
                ->references('category_id')
                ->on('categories')
                ->onDelete('cascade');

            $table->foreign('sub_category_id')
                ->references('category_id')
                ->on('categories')
                ->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('award_categories');
    }
}
