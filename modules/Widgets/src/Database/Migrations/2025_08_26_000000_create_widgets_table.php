<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('widgets', function (Blueprint $table) {
            $table->id();
            $table->string('title');

            // query config
            $table->string('table_name');         // base table
            $table->string('column_name')->nullable(); // aggregate column (nullable for count)
            $table->enum('operation', [
                'count',
                'sum',
                'avg',
                'min',
                'max',
                'profit_loss',
                'month_compare'
            ])->default('count');

            $table->enum('is_currency', [
                'Y', 'N'
            ])->default('N');
            // profit/loss specific
            $table->string('revenue_column')->nullable();
            $table->string('cost_column')->nullable();

            // joins (JSON array)
            $table->json('joins')->nullable(); // [{table, local_column, foreign_column, type}...]
            $table->json('conditions')->nullable(); // [{table, local_column, foreign_column, type}...]

            // date filtering
            $table->string('date_column')->nullable(); // e.g. orders.created_at
            $table->enum('date_filter', ['none', 'today', 'week', 'month', 'year', 'custom'])->default('none');
            $table->date('date_from')->nullable();
            $table->date('date_to')->nullable();

            // widget rendering
            $table->enum('widget_type', ['stat', 'line', 'bar', 'pie', 'worldmap'])->default('stat');

            // assignment
            $table->json('user_groups')->nullable(); // ["admin","manager"]

            // optional group-by for charts
            $table->string('group_by')->nullable(); // e.g. DATE(orders.created_at) or products.category_id
            $table->string('sort_order')->default(0);
            $table->integer('pos_x')->default(0);
            $table->integer('pos_y')->default(0);
            $table->integer('width')->default(1);
            $table->integer('height')->default(1);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('widgets');
    }
};
