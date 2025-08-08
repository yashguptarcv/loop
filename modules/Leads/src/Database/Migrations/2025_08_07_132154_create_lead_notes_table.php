<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('lead_notes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lead_id')->constrained()->cascadeOnDelete();
            $table->foreignId('admin_id')->constrained()->cascadeOnDelete();
            $table->text('note');
            $table->boolean('is_private')->default(false);
            $table->timestamps();
            
            // Indexes
            $table->index('lead_id');
            $table->index('admin_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('lead_notes');
    }
};