<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('admin_id')->nullable()->unsigned();
            $table->string('name');
            $table->string('coupon_code');
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('coupon_per_user')->nullable();
            $table->integer('coupon_used_count')->nullable();
            $table->enum('coupon_type', ['F', 'P'])->default('F'); // Coupon type ( f - fixed or P - percentage)
            $table->integer('coupon_value');
            $table->string('coupon_status')->default(0);
            $table->string('coupon_message');

            $table->foreign('admin_id')->references('id')->on('admins');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
