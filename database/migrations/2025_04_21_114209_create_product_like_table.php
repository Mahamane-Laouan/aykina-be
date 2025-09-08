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
    Schema::create('product_like', function (Blueprint $table) {
      $table->increments('id'); // Primary key, auto increment
      $table->string('product_id')->nullable(); // product_id (varchar)
      $table->string('user_id')->nullable(); // user_id (varchar)
      $table->timestamps(); // created_at and updated_at
    });
  }


  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('product_like');
  }
};
