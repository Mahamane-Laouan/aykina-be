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
    Schema::create('service_proof', function (Blueprint $table) {
      $table->increments('id');
      $table->string('service_name')->nullable();
      $table->string('handyman_id')->nullable();
      $table->string('user_id')->nullable();
      $table->string('notes')->nullable();
      $table->text('image')->nullable();
      $table->string('booking_id')->nullable();
      $table->text('rev_star')->nullable();
      $table->text('rev_text')->nullable();
      $table->timestamps(); // created_at & updated_at
    });
  }


  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('service_proof');
  }
};
