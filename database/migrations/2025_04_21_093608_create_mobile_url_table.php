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
    Schema::create('mobile_url', function (Blueprint $table) {
      $table->increments('id'); // Auto-incrementing primary key
      $table->text('android_url')->nullable(); // URL for the Android app
      $table->text('android_provider_url')->nullable(); // Provider URL for Android
      $table->text('ios_url')->nullable(); // URL for the iOS app
      $table->text('ios_provider_url')->nullable(); // Provider URL for iOS
      $table->timestamps(); // created_at and updated_at timestamps
    });


    // Insert default about content
    DB::table('mobile_url')->insert([
      'id' => 1,
      'android_url' => 'https://primocys.com/',
      'android_provider_url' => 'https://primocys.com/',
      'ios_url' => 'https://primocys.com/',
      'ios_provider_url' => "https://primocys.com/",
      'created_at' => '2024-09-24 10:35:59',
      'updated_at' => '2025-03-19 09:06:28',
    ]);
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('mobile_url');
  }
};
