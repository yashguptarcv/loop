<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('company')->nullable();
            $table->text('description')->nullable();
            $table->decimal('value', 10, 2)->nullable();
            
            // Foreign key to lead_statuses table
            $table->foreignId('status_id')->constrained('lead_statuses');
            
            // Foreign key to users table (assigned to)
            $table->foreignId('assigned_to')->nullable()->constrained('users');
            
            // Foreign key to users table (created by)
            $table->foreignId('created_by')->constrained('users');
            
            // Source of the lead (website, referral, etc.)
            $table->string('source')->nullable();
            
            $table->softDeletes();
            $table->timestamps();
            
            // Indexes
            $table->index('status_id');
            $table->index('assigned_to');
            $table->index('created_by');
        });
    }

    public function down()
    {
        Schema::dropIfExists('leads');
    }
};