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
    Schema::create('handyman_history', function (Blueprint $table) {
      $table->increments('id'); // Auto-incrementing primary key
      $table->string('handyman_id', 255)->nullable(); // Handyman ID
      $table->bigInteger('total_bal')->nullable(); // Total balance (bigint)
      $table->string('available_bal', 255)->nullable(); // Available balance
      $table->string('show_balance', 255)->nullable(); // Show balance
      $table->string('handyman_status', 255)->nullable(); // Handyman status
      $table->string('provider_status', 255)->nullable(); // Provider status
      $table->timestamps(); // created_at and updated_at timestamps
    });
  }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('handyman_history');
    }
};
