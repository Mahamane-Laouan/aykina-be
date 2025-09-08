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
    Schema::create('booking_provider_history', function (Blueprint $table) {
      $table->integer('id', false, true)->length(11)->autoIncrement();  // Primary int(11) UNSIGNED auto-increment
      $table->string('handyman_id', 11)->nullable();
      $table->string('provider_id', 11)->nullable();
      $table->string('booking_id', 11)->nullable();
      $table->string('order_id', 255)->nullable();
      $table->string('service_id', 11)->nullable();
      $table->string('user_id', 11)->nullable();
      $table->string('commision_persontage', 11)->nullable();
      $table->string('amount', 255)->nullable();
      $table->timestamps();
    });
  }


  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('booking_provider_history');
  }
};
