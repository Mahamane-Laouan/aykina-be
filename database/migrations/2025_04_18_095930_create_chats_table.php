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
    Schema::create('chats', function (Blueprint $table) {
      $table->id();
      $table->string('from_user')->nullable(); // or use ->unsignedBigInteger() if referring to user id
      $table->string('to_user')->nullable();
      $table->text('message')->nullable();
      $table->string('url')->nullable();
      $table->string('type')->nullable(); // e.g., text, image, file
      $table->string('date')->nullable(); // ideally you'd use a proper datetime
      $table->string('time')->nullable(); // same here
      $table->string('read_message')->default('0'); // use boolean/tinyint if needed
      $table->string('timestamp', 100)->nullable(); // used for ordering in frontend?
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('chats');
  }
};
