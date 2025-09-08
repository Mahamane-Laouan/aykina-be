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
    Schema::create('bank_details', function (Blueprint $table) {
      $table->integer('id', false, true)->length(11)->autoIncrement();  // Primary int(11) UNSIGNED auto-increment
      $table->string('user_id', 255)->nullable();
      $table->string('provider_id', 255)->nullable();
      $table->string('bank_name', 255)->nullable();
      $table->string('branch_name', 255)->nullable();
      $table->text('acc_number')->nullable();
      $table->string('ifsc_code', 255)->nullable();
      $table->string('mobile_number', 255)->nullable();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('bank_details');
  }
};
