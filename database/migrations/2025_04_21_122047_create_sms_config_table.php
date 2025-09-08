<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
  /**
   * Run the migrations.
   */
  public function up()
  {
    Schema::create('sms_config', function (Blueprint $table) {
      $table->increments('id');
      $table->text('twilio_sid')->nullable(); // text
      $table->text('twilio_auth_token')->nullable(); // text
      $table->text('twilio_phone_number')->nullable(); // text
      $table->text('msg91_auth_key')->nullable(); // text
      $table->text('msg91_private_key')->nullable(); // text
      $table->timestamps(0); // created_at & updated_at with current_timestamp
    });

    // Insert default about content
    DB::table('sms_config')->insert([
      'id' => 1,
      'twilio_sid' => null,
      'twilio_auth_token' => null,
      'twilio_phone_number' => null,
      'msg91_auth_key' => null,
      'msg91_private_key' => null,
      'created_at' => '2024-09-24 10:35:59',
      'updated_at' => '2025-03-19 09:06:28',
    ]);
  }


  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('sms_config');
  }
};
