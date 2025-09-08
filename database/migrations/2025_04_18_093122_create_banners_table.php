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
    Schema::create('banners', function (Blueprint $table) {
      $table->integer('id', false, true)->length(11)->autoIncrement();  // Primary int(11) UNSIGNED auto-increment
      $table->string('banner_name', 255)->nullable();
      $table->string('cat_id', 255)->nullable();
      $table->text('banner_image')->nullable();
      $table->timestamps();
    });

    // Insert default about content
    DB::table('banners')->insert([
      'id' => 1,
      'banner_name' => 'Slider 1',
      'cat_id' => '1',
      'banner_image' => '1743581153.png',
      'created_at' => '2024-09-24 10:35:59',
      'updated_at' => '2025-03-19 09:06:28',
    ]);

    // Insert default about content
    DB::table('banners')->insert([
      'id' => 2,
      'banner_name' => 'Slider 2',
      'cat_id' => '2',
      'banner_image' => '1743581092.png',
      'created_at' => '2024-09-24 10:35:59',
      'updated_at' => '2025-03-19 09:06:28',
    ]);


    // Insert default about content
    DB::table('banners')->insert([
      'id' => 3,
      'banner_name' => 'Slider 3',
      'cat_id' => '3',
      'banner_image' => '1743581067.jpg',
      'created_at' => '2024-09-24 10:35:59',
      'updated_at' => '2025-03-19 09:06:28',
    ]);
  }


  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('banners');
  }
};
