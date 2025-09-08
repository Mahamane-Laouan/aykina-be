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
    Schema::create('user_login_status', function (Blueprint $table) {
      $table->increments('id');
      $table->string('text')->nullable();
      $table->integer('status')->default(0);
      $table->integer('handyman_status')->nullable()->default(0);
      $table->timestamps();
    });

    // Insert default about content
    DB::table('user_login_status')->insert([
      'id' => 1,
      'text' => 'otp',
      'status' => 1,
      'handyman_status' => 1,
      'created_at' => '2024-09-24 10:35:59',
      'updated_at' => '2025-03-19 09:06:28',
    ]);

    // Insert default about content
    DB::table('user_login_status')->insert([
      'id' => 2,
      'text' => 'google',
      'status' => 1,
      'handyman_status' => 1,
      'created_at' => '2024-09-24 10:35:59',
      'updated_at' => '2025-03-19 09:06:28',
    ]);


    // Insert default about content
    DB::table('user_login_status')->insert([
      'id' => 3,
      'text' => 'apple',
      'status' => 1,
      'handyman_status' => 1,
      'created_at' => '2024-09-24 10:35:59',
      'updated_at' => '2025-03-19 09:06:28',
    ]);


    // Insert default about content
    DB::table('user_login_status')->insert([
      'id' => 4,
      'text' => 'facebook',
      'status' => 1,
      'handyman_status' => 1,
      'created_at' => '2024-09-24 10:35:59',
      'updated_at' => '2025-03-19 09:06:28',
    ]);
  }


  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('user_login_status');
  }
};
