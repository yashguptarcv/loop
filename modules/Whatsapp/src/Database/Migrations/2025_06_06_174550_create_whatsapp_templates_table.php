<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('whatsapp_templates', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('category');
            $table->string('language');
            $table->text('header_text')->nullable();
            $table->string('header_type')->nullable();
            $table->text('body_text');
            $table->text('footer_text')->nullable();
            $table->string('header_image_url')->nullable();
            $table->string('header_video_url')->nullable();
            $table->string('header_document_url')->nullable();
            $table->json('body_examples')->nullable();
            $table->json('buttons')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected', 'in_appeal'])->default('pending');
            $table->string('template_id')->nullable();
            $table->json('api_response')->nullable();
            $table->text('rejection_reason')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::table('whatsapp_templates', function (Blueprint $table) {
            $table->dropColumn(['header_image_url', 'header_video_url', 'header_document_url', 'body_examples']);
        });
    }
};