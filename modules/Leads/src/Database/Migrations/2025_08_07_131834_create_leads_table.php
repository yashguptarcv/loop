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
            $table->string('industries')->nullable();
            $table->string('website')->nullable();
            $table->string('address')->nullable();
            $table->string('address_2')->nullable();
            $table->string('country')->nullable();
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->string('postal_code')->nullable();
            
            $table->text('custom_fields')->nullable();
            
            // Foreign key to lead_statuses table
            $table->unsignedBigInteger('status_id');
            $table->foreign('status_id')
                  ->references('id')
                  ->on('lead_statuses')
                  ->onDelete('cascade');

            // Foreign key to users table (assigned to)
            $table->unsignedBigInteger('assigned_to')->nullable();
            $table->foreign('assigned_to')
                  ->references('id')
                  ->on('admins')
                  ->onDelete('set null');

            // Foreign key to admins table (created by)
            $table->unsignedBigInteger('created_by');
            $table->foreign('created_by')
                  ->references('id')
                  ->on('admins')
                  ->onDelete('cascade');
            
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
