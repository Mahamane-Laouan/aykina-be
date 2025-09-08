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
    Schema::create('default_image', function (Blueprint $table) {
      $table->id();
      $table->integer('people_id')->nullable();
      $table->string('role')->nullable();
      $table->text('image')->nullable();
      $table->timestamps();
    });

    // Insert default about content
    DB::table('default_image')->insert([
      'id' => 1,
      'people_id' => 1,
      'role' => 'provider',
      'image' => 'provider.jpg',
      'created_at' => '2024-09-24 10:35:59',
      'updated_at' => '2025-03-19 09:06:28',
    ]);

    // Insert default about content
    DB::table('default_image')->insert([
      'id' => 2,
      'people_id' => 2,
      'role' => 'handyman',
      'image' => 'handyman.jpg',
      'created_at' => '2024-09-24 10:35:59',
      'updated_at' => '2025-03-19 09:06:28',
    ]);

    // Insert default about content
    DB::table('default_image')->insert([
      'id' => 3,
      'people_id' => 3,
      'role' => 'user',
      'image' => 'user_none.jpg',
      'created_at' => '2024-09-24 10:35:59',
      'updated_at' => '2025-03-19 09:06:28',
    ]);


  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('default_image');
  }
};
