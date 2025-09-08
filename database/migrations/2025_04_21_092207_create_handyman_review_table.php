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
    Schema::create('handyman_review', function (Blueprint $table) {
      $table->increments('id'); // Auto-incrementing primary key
      $table->string('handyman_id', 255)->nullable(); // Handyman ID
      $table->string('service_id', 255)->nullable(); // Service ID
      $table->string('provider_id', 11)->nullable(); // Provider ID (varchar length 11)
      $table->string('user_id', 255)->nullable(); // User ID
      $table->string('booking_id', 255)->nullable(); // Booking ID
      $table->string('star_count', 255)->nullable(); // Star count (varchar)
      $table->string('text', 255)->nullable(); // Review text
      $table->timestamps(); // created_at and updated_at timestamps
    });
  }
  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('handyman_review');
  }
};
