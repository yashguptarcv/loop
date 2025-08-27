<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up()
    {
        Schema::create('lead_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('color')->default('gray'); // For UI coloring
            $table->integer('sort')->default(0); // For sorting in UI
            $table->boolean('is_default')->default(false);
            $table->timestamps();
        });

        // Insert default statuses
        DB::table('lead_statuses')->insert([
            ['name' => 'New', 'color' => 'blue', 'sort' => 1, 'is_default' => true],
            ['name' => 'Contacted', 'color' => 'purple', 'sort' => 2, 'is_default' => false],
            ['name' => 'Qualified', 'color' => 'green', 'sort' => 3, 'is_default' => false],
            ['name' => 'Proposal Sent', 'color' => 'yellow', 'sort' => 4, 'is_default' => false],
            ['name' => 'Negotiation', 'color' => 'orange', 'sort' => 5, 'is_default' => false],
            ['name' => 'Closed Won', 'color' => 'green', 'sort' => 6, 'is_default' => false],
            ['name' => 'Closed Lost', 'color' => 'red', 'sort' => 7, 'is_default' => false],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('lead_statuses');
    }
};
