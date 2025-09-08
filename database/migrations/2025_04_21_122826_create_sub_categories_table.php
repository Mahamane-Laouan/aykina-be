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
    Schema::create('sub_categories', function (Blueprint $table) {
      $table->increments('id');
      $table->integer('cat_id')->nullable(); // Foreign key to categories (assumed)
      $table->string('c_name')->nullable();
      $table->text('img')->nullable();
      $table->integer('status')->default(1);
      $table->timestamp('created_at')->nullable();
      $table->timestamp('updated_at')->nullable();
    });
  }


  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('sub_categories');
  }
};
