<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('lead_activities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lead_id')->constrained()->cascadeOnDelete();
            $table->foreignId('admin_id')->constrained()->cascadeOnDelete();
            $table->string('type'); // call, email, meeting, etc.
            $table->text('description');
            $table->dateTime('activity_date');
            $table->integer('duration_minutes')->nullable(); // for calls/meetings
            $table->string('outcome')->nullable();
            $table->timestamps();
            
            // Indexes
            $table->index('lead_id');
            $table->index('admin_id');
            $table->index('activity_date');
        });
    }

    public function down()
    {
        Schema::dropIfExists('lead_activities');
    }
};