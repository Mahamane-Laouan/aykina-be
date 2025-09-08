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
    Schema::create('tickets', function (Blueprint $table) {
      $table->increments('id');
      $table->string('subject')->nullable();
      $table->text('description')->nullable();
      $table->string('order_id')->nullable();
      $table->string('type')->nullable(); // e.g., complaint, query, etc.
      $table->text('image')->nullable();
      $table->string('user_id')->nullable(); // Can be changed to foreignId if you're linking to users
      $table->timestamp('created_at')->nullable();
      $table->timestamp('updated_at')->nullable();
    });
  }


  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('tickets');
  }
};
