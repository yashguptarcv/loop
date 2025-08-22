<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('whatsapp_event_templates', function (Blueprint $table) {
            $table->id();
            $table->string('event_key')->unique()->comment('Unique key representing an application event (e.g., user_created, agency_logged_in)');
            $table->string('template_name')->comment('The name of the WhatsApp template to use for this event');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('whatsapp_event_templates');
    }
}; 