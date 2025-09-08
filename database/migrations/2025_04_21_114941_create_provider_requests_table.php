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
    Schema::create('provider_requests', function (Blueprint $table) {
      $table->increments('id');
      $table->integer('provider_id')->nullable();
      $table->string('bank_id')->nullable();
      $table->integer('amount')->nullable();
      $table->tinyInteger('status')->nullable();
      $table->integer('is_read')->default(0);
      $table->integer('is_color')->default(0);
      $table->timestamps(); // created_at & updated_at
    });
  }

  /**
   * Reverse the migrations.
   */
    public function down(): void
    {
        Schema::dropIfExists('provider_requests');
    }
};
