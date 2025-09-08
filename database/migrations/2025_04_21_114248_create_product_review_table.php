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
    Schema::create('product_review', function (Blueprint $table) {
      $table->increments('id'); // Primary key
      $table->string('user_id')->nullable(); // varchar(255)
      $table->string('product_id')->nullable();
      $table->string('booking_id')->nullable();
      $table->string('provider_id')->nullable();
      $table->text('text')->nullable();
      $table->string('star_count')->nullable();
      $table->timestamps(); // created_at and updated_at
    });
  }


  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('product_review');
  }
};
