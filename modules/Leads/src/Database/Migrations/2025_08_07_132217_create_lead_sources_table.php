<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up()
    {
        Schema::create('lead_sources', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Insert default sources
        DB::table('lead_sources')->insert([
            ['name' => 'Website', 'slug' => 'website', 'description' => 'Lead came from website form'],
            ['name' => 'Referral', 'slug' => 'referral', 'description' => 'Lead was referred by someone'],
            ['name' => 'Social Media', 'slug' => 'social-media', 'description' => 'Lead came from social media'],
            ['name' => 'Email Campaign', 'slug' => 'email-campaign', 'description' => 'Lead came from email marketing'],
            ['name' => 'Cold Call', 'slug' => 'cold-call', 'description' => 'Lead from outbound calling'],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('lead_sources');
    }
};