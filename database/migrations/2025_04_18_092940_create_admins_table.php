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
    Schema::create('admins', function (Blueprint $table) {
      $table->bigIncrements('id')->unsigned();  // bigint(20) UNSIGNED auto-increment
      $table->string('firstname', 255)->nullable();
      $table->string('lastname', 255)->nullable();
      $table->string('email', 255)->nullable();
      $table->string('mobile', 12)->nullable();
      $table->string('profile_pic', 255)->nullable();
      $table->string('password', 255)->nullable();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('admins');
  }
};
