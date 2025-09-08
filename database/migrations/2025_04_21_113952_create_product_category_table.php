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
    Schema::create('product_category', function (Blueprint $table) {
      $table->id(); // id - primary key, auto increment
      $table->text('c_name')->nullable(); // category name
      $table->text('image')->nullable(); // category image
      $table->timestamps(); // created_at and updated_at
    });
  }


  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('product_category');
  }
};
