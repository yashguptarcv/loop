<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('admins', function (Blueprint $table) {
            $table->text('google_access_token')->nullable()->after('remember_token');
            $table->text('google_refresh_token')->nullable()->after('google_access_token');
            $table->integer('google_expires_in')->nullable()->after('google_refresh_token');
            $table->string('google_token_type', 50)->nullable()->after('google_expires_in');
            $table->timestamp('google_token_created_at')->nullable()->after('google_token_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('admins', function (Blueprint $table) {
            $table->dropColumn([
                'google_access_token',
                'google_refresh_token',
                'google_expires_in',
                'google_token_type',
                'google_token_created_at'
            ]);
        });
    }
};