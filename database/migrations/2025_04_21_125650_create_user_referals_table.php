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
    Schema::create('user_referals', function (Blueprint $table) {
      $table->bigIncrements('id')->unsigned();
      $table->integer('user_id');
      $table->string('refer_code');
      $table->string('user_refer_code');
      $table->integer('use_refer_code_by');
      $table->timestamps();
    });
  }


  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('user_referals');
  }
};
