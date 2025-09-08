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
    Schema::create('addon_product', function (Blueprint $table) {
      // Define the 'id' column as an auto-incrementing integer
      $table->integer('id', false, true)->length(11)->autoIncrement();  // Primary int(11) unsigned auto-increment

      // Define other columns with varchar type (255) and utf8_unicode_ci collation
      $table->string('product_id', 255)->nullable();
      $table->string('service_id', 255)->nullable();
      $table->string('vid', 255)->nullable();

      // Timestamps for created_at and updated_at
      $table->timestamps();
    });
  }


  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('addon_product');
  }
};
