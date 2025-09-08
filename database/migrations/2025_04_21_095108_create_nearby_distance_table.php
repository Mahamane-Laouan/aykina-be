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
    Schema::create('nearby_distance', function (Blueprint $table) {
      $table->increments('id');
      $table->text('distance')->nullable();
      $table->text('distance_type')->nullable();
      $table->timestamps(); // adds created_at and updated_at
    });


    // Insert default about content
    DB::table('nearby_distance')->insert([
      'id' => 1,
      'distance' => '2',
      'distance_type' => 'km',
      'created_at' => '2024-09-24 10:35:59',
      'updated_at' => '2025-03-19 09:06:28',
    ]);
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('nearby_distance');
  }
};
