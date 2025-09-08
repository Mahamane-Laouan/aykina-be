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
    Schema::create('provider_bank_details', function (Blueprint $table) {
      $table->increments('id');
      $table->string('provider_id')->nullable();
      $table->string('bank_name')->nullable();
      $table->string('branch_name')->nullable();
      $table->string('acc_number')->nullable();
      $table->string('ifsc_code')->nullable();
      $table->string('mobile_number')->nullable();
      $table->timestamps(); // created_at & updated_at
    });
  }


  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('provider_bank_details');
  }
};
