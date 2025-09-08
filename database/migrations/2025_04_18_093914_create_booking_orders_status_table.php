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
    Schema::create('booking_orders_status', function (Blueprint $table) {
      $table->integer('id', false, true)->length(11)->autoIncrement();  // Primary int(11) UNSIGNED auto-increment
      $table->string('booking_id', 255)->nullable();
      $table->string('provider_id', 255)->nullable();
      $table->string('work_assign_id', 255)->nullable();
      $table->string('status', 255)->nullable();
      $table->string('electricity_on', 255)->nullable();
      $table->string('reason', 255)->nullable();
      $table->timestamps();
    });
  }


  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('booking_orders_status');
  }
};
