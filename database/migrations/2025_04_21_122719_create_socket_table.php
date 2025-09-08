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
    Schema::create('socket_table', function (Blueprint $table) {
      $table->increments('id');
      $table->string('user_id')->nullable();
      $table->string('socket_id')->nullable();
      $table->timestamps(0); // created_at and updated_at with no fractional seconds
    });
  }


  /**
   * Reverse the migrations.
   */
    public function down(): void
    {
        Schema::dropIfExists('socket');
    }
};
