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
    Schema::create('social_media', function (Blueprint $table) {
      $table->increments('id');
      $table->text('facebook_link')->nullable();
      $table->text('whatsapp_link')->nullable();
      $table->text('instagram_link')->nullable();
      $table->text('twitter_link')->nullable();
      $table->text('youtube_link')->nullable();
      $table->text('linkdln_link')->nullable();
      $table->timestamps(0); // created_at, updated_at with no fractional seconds
    });

    // Insert default about content
    DB::table('social_media')->insert([
      'id' => 1,
      'facebook_link' => 'https://www.facebook.com/primocys',
      'whatsapp_link' => 'wa.me/919601814016',
      'instagram_link' => 'https://www.instagram.com/primocys',
      'twitter_link' => 'https://www.twitter.com/primocys',
      'youtube_link' => 'https://www.youtube.com/@primocys1443',
      'linkdln_link' => 'https://www.linkedin.com/company/primocys/',
      'created_at' => '2024-09-24 10:35:59',
      'updated_at' => '2025-03-19 09:06:28',
    ]);
  }


  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('social_media');
  }
};
