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
    Schema::create('support_chat', function (Blueprint $table) {
      $table->increments('id');
      $table->string('from_user')->nullable();
      $table->string('to_user')->nullable();
      $table->string('order_number')->nullable();
      $table->text('message')->nullable();
      $table->text('url')->nullable();
      $table->text('type')->nullable(); // Could be "text", "image", "file", etc.
      $table->string('subject')->nullable();
      $table->integer('admin_message')->default(0); // 1 if it's an admin message
      $table->timestamp('created_at')->nullable();
      $table->timestamp('updated_at')->nullable();
      $table->string('status')->default(0); // Example: "0" = unread, "1" = read
    });
  }


  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('support_chat');
  }
};
