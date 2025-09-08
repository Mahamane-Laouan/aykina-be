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
    Schema::create('support_chat_status', function (Blueprint $table) {
      $table->increments('id');
      $table->string('from_user')->nullable();
      $table->string('to_user')->nullable();
      $table->string('order_number')->nullable();
      $table->integer('status')->default(0); // Example: 0 = unread, 1 = read
      $table->timestamp('created_at')->nullable();
      $table->timestamp('updated_at')->nullable();
    });
  }


  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('support_chat_status');
  }
};
