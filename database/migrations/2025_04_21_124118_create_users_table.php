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
    Schema::create('users', function (Blueprint $table) {
      $table->increments('id');
      $table->integer('people_id')->nullable();
      $table->string('firstname')->nullable();
      $table->string('lastname')->nullable();
      $table->string('email')->nullable();
      $table->text('mobile')->nullable();
      $table->text('country_code')->nullable();
      $table->string('password')->nullable();
      $table->text('main_password')->nullable();
      $table->string('user_role')->nullable();
      $table->string('provider_id')->nullable();
      $table->string('otp')->nullable();
      $table->string('country_flag')->nullable();
      $table->string('verified_code')->nullable();
      $table->string('login_type')->nullable();
      $table->string('google_id')->nullable();
      $table->string('profile_pic')->nullable();
      $table->string('city')->nullable();
      $table->string('state')->nullable();
      $table->string('location')->nullable();
      $table->string('device_token')->nullable();
      $table->string('is_online')->default('0');
      $table->string('status')->nullable();
      $table->string('wallet_balance')->nullable();
      $table->timestamp('email_verified_at')->nullable();
      $table->string('latitude')->nullable();
      $table->string('longitude')->nullable();
      $table->string('refer_code')->nullable();
      $table->string('user_refer_code')->nullable();
      $table->string('otp_status')->default('0');
      $table->string('mobile_verified_otp')->nullable();
      $table->integer('confirmation')->default(0);
      $table->integer('is_blocked')->default(1);
      $table->integer('is_read')->default(0);
      $table->integer('is_color')->default(0);
      $table->timestamps();
    });


    // Insert default about content
    DB::table('users')->insert([
      'id' => 1,
      'people_id' => null,
      'firstname' => 'Handy',
      'lastname' => 'Hue',
      'email' => 'admin@gmail.com',
      'mobile' => null,
      'country_code' => null,
      'password' => '$2y$10$p33Mz91SmaupCS32QBaxJOL0uMfiaZCv.MV43crq64Jqz1C5Gb/PO',
      'main_password' => null,
      'user_role' => "Admin",
      'provider_id' => null,
      'otp' => null,
      'country_flag' => null,
      'verified_code' => null,
      'login_type' => null,
      'google_id' => null,
      'profile_pic' => '1741771157_image_67d1519574011.png',
      'city' => null,
      'state' => null,
      'location' => null,
      'device_token' => null,
      'is_online' => '0',
      'status' => null,
      'wallet_balance' => null,
      'email_verified_at' => null,
      'latitude' => null,
      'longitude' => null,
      'refer_code' => null,
      'user_refer_code' => null,
      'otp_status' => '0',
      'mobile_verified_otp' => null,
      'confirmation' => 0,
      'is_blocked' => 1,
      'is_read' => 0,
      'is_color' => 0,
      'created_at' => '2025-03-19 09:06:28',
      'updated_at' => '2025-03-19 09:06:28',
    ]);


    // Insert default about content
    DB::table('users')->insert([
      'id' => 2,
      'people_id' => 1,
      'firstname' => 'Provider',
      'lastname' => null,
      'email' => 'provider@gmail.com',
      'mobile' => null,
      'country_code' => null,
      'password' => '$2y$10$p33Mz91SmaupCS32QBaxJOL0uMfiaZCv.MV43crq64Jqz1C5Gb/PO',
      'main_password' => null,
      'user_role' => "provider",
      'provider_id' => null,
      'otp' => null,
      'country_flag' => null,
      'verified_code' => null,
      'login_type' => null,
      'google_id' => null,
      'profile_pic' => null,
      'city' => null,
      'state' => null,
      'location' => null,
      'device_token' => null,
      'is_online' => '0',
      'status' => null,
      'wallet_balance' => null,
      'email_verified_at' => null,
      'latitude' => null,
      'longitude' => null,
      'refer_code' => null,
      'user_refer_code' => null,
      'otp_status' => '0',
      'mobile_verified_otp' => null,
      'confirmation' => 0,
      'is_blocked' => 1,
      'is_read' => 0,
      'is_color' => 0,
      'created_at' => '2025-03-19 09:06:28',
      'updated_at' => '2025-03-19 09:06:28',
    ]);
  }


  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('users');
  }
};
