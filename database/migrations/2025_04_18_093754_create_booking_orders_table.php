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
    Schema::create('booking_orders', function (Blueprint $table) {
      $table->integer('id', false, true)->length(11)->autoIncrement();  // Primary int(11) UNSIGNED auto-increment
      $table->string('cat_name', 255)->nullable();
      $table->string('payment', 255)->nullable();
      $table->text('location')->nullable();
      $table->string('booking_status', 255)->nullable();
      $table->string('user_id', 255)->nullable();
      $table->string('on_status', 255)->nullable();
      $table->integer('work_assign_id', false, true)->length(11)->nullable();
      $table->string('provider_id', 255)->nullable();
      $table->string('payment_method', 255)->nullable();
      $table->string('service_id', 255)->nullable();
      $table->string('product_id', 255)->nullable();
      $table->string('cart_id', 255)->nullable();
      $table->integer('handyman_status', false, true)->default(0)->nullable();  // Default 0
      $table->string('otp', 255)->nullable();
      $table->string('is_online', 255)->default(0)->nullable();  // Default 0
      $table->timestamps();
    });
  }


  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('booking_orders');
  }
};
