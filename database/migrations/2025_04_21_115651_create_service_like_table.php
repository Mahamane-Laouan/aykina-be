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
    Schema::create('service_like', function (Blueprint $table) {
      $table->increments('id');
      $table->string('service_id')->nullable();
      $table->string('user_id')->nullable();
      $table->timestamps(); // created_at & updated_at
    });
  }


  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('service_like');
  }
};
