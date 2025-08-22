<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // tax_rules table (junction table)
        Schema::create('tax_rules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tax_category_id')->constrained();
            $table->foreignId('tax_rate_id')->constrained();
            $table->integer('priority')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tax_rules');
    }
};
