<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('leads', function (Blueprint $table) {
            $table->foreignId('source_id')->nullable()->after('status_id')
                  ->constrained('lead_sources')->nullOnDelete();
        });
    }

    public function down()
    {
        Schema::table('leads', function (Blueprint $table) {
            $table->dropForeign(['source_id']);
            $table->dropColumn('source_id');
        });
    }
};