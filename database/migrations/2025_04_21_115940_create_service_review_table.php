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
    Schema::create('service_review', function (Blueprint $table) {
      $table->increments('id');
      $table->string('user_id')->nullable();
      $table->string('service_id')->nullable();
      $table->string('booking_id')->nullable();
      $table->integer('provider_id')->nullable();
      $table->text('text')->nullable();
      $table->string('star_count')->nullable();
      $table->timestamps(); // created_at & updated_at
    });
  }


  /**
   * Reverse the migrations.
   */
    public function down(): void
    {
        Schema::dropIfExists('service_review');
    }
};
