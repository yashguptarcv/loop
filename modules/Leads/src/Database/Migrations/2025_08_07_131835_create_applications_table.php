<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicationsTable extends Migration
{
    public function up()
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            
            // Customer details
            $table->string('full_name');
            $table->string('mobile');
            $table->string('email');
            $table->string('alternate_contact')->nullable();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('lead_id')->constrained()->cascadeOnDelete();
            
            // Organization details
            $table->string('organization')->nullable();
            $table->string('designation')->nullable();
            
            // Billing address (stored as JSON)
            $table->json('billing_address')->nullable();
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('applications');
    }
}