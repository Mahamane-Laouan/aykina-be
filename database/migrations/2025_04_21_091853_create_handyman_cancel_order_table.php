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
    Schema::create('handyman_cancel_order', function (Blueprint $table) {
      $table->increments('id'); // Auto-incrementing primary key
      $table->string('booking_order_id')->nullable(); // Booking order ID
      $table->string('handyman_id')->nullable(); // Handyman ID
      $table->string('handyman_status')->nullable(); // Handyman status
      $table->timestamps(); // created_at and updated_at timestamps
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('handyman_cancel_order');
  }
};
