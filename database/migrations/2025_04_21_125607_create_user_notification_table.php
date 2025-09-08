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
    Schema::create('user_notification', function (Blueprint $table) {
      $table->increments('not_id');
      $table->string('user_id')->nullable();
      $table->string('handyman_id')->nullable();
      $table->string('provider_id')->nullable();
      $table->text('title');
      $table->string('type')->nullable();
      $table->string('booking_id')->nullable();
      $table->string('order_id')->nullable();
      $table->text('message');
      $table->integer('read_status')->default(0);
      $table->string('requests_status')->default(0);
      $table->integer('not_type')->default(0);
      $table->string('read_provider')->default(0);
      $table->string('read_handyman')->default(0);
      $table->string('read_user')->default(0);
      $table->integer('review_noti')->default(0);
      $table->text('date')->nullable();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('user_notification');
  }
};
