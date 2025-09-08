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
    Schema::create('people_role', function (Blueprint $table) {
      $table->increments('id');
      $table->text('people_role')->nullable();
      $table->timestamps();
    });

    // Insert default about content
    DB::table('people_role')->insert([
      'id' => 1,
      'people_role' => 'provider',
      'created_at' => '2024-09-24 10:35:59',
      'updated_at' => '2025-03-19 09:06:28',
    ]);


    // Insert default about content
    DB::table('people_role')->insert([
      'id' => 2,
      'people_role' => 'handyman',
      'created_at' => '2024-09-24 10:35:59',
      'updated_at' => '2025-03-19 09:06:28',
    ]);


    // Insert default about content
    DB::table('people_role')->insert([
      'id' => 3,
      'people_role' => 'user',
      'created_at' => '2024-09-24 10:35:59',
      'updated_at' => '2025-03-19 09:06:28',
    ]);
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('people_role');
  }
};
