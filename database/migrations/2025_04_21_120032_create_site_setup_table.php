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
    Schema::create('site_setup', function (Blueprint $table) {
      $table->increments('id');
      $table->text('name')->nullable();
      $table->text('min_amountbook')->nullable();
      $table->text('distance')->nullable();
      $table->text('distance_type')->nullable();
      $table->text('platform_fees')->nullable();
      $table->text('time_zone')->nullable();
      $table->text('default_currency')->nullable();
      $table->text('default_currency_name')->nullable();
      $table->text('copyright_text')->nullable();
      $table->text('google_map_key')->nullable();
      $table->text('light_logo')->nullable();
      $table->text('dark_logo')->nullable();
      $table->text('fav_icon')->nullable();
      $table->text('color_code')->nullable();
      $table->text('purchase_code')->nullable();
      $table->timestamps(); // created_at & updated_at
    });


    // Insert default about content
    DB::table('site_setup')->insert([
      'id' => 1,
      'name' => 'HandyHue',
      'min_amountbook' => '20',
      'distance' => null,
      'distance_type' => null,
      'platform_fees' => '25',
      'time_zone' => 'Asia/Kolkata',
      'default_currency' => '$',
      'default_currency_name' => 'USD',
      'copyright_text' => 'Copyright 2025 © HandyHue theme by Primocys',
      'google_map_key' => null,
      'light_logo' => '1747741494_light_logo_682c6b36b1015.png',
      'dark_logo' => '1747741494_dark_logo_682c6b36b1302.png',
      'fav_icon' => '1747741515_favicon_682c6b4bb6514.png',
      'color_code' => '#246fc1',
      'purchase_code' => null,
      'created_at' => '2024-09-24 10:35:59',
      'updated_at' => '2025-03-19 09:06:28',
    ]);
  }


  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('site_setup');
  }
};
