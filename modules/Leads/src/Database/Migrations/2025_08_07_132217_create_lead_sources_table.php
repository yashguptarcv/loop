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
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Insert default sources
        DB::table('lead_sources')->insert([
            ['name' => 'Website'],
            ['name' => 'Referral'],
            ['name' => 'Social Media'],
            ['name' => 'Email Campaign'],
            ['name' => 'Cold Call'],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('lead_sources');
    }
};