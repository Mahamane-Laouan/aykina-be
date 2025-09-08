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
    Schema::create('product_images', function (Blueprint $table) {
      $table->bigIncrements('id'); // Primary key, bigint unsigned, auto increment
      $table->integer('product_id')->nullable(); // product_id (foreign key reference to products table, optional)
      $table->string('product_image', 255)->nullable(); // image path
      $table->timestamps(); // created_at & updated_at
    });
  }


  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('product_images');
  }
};
