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
    Schema::create('categories', function (Blueprint $table) {
      $table->integer('id', false, true)->length(11)->autoIncrement();  // Primary int(11) UNSIGNED auto-increment
      $table->string('c_name', 255)->charset('utf8')->collation('utf8_general_ci')->nullable();
      $table->string('img', 255)->charset('utf8')->collation('utf8_general_ci')->nullable();
      $table->integer('status', false, true)->length(11)->default(1);  // int(11), status column (default: 1)
      $table->timestamps();  // created_at, updated_at
    });

    // Insert default about content
    DB::table('categories')->insert([
      'id' => 1,
      'c_name' => 'AC Repair',
      'img' => '1739279511.png',
      'status' => 1,
      'created_at' => '2024-09-24 10:35:59',
      'updated_at' => '2025-03-19 09:06:28',
    ]);

    // Insert default about content
    DB::table('categories')->insert([
      'id' => 2,
      'c_name' => 'Carpenter',
      'img' => '1739279846.png',
      'status' => 1,
      'created_at' => '2024-09-24 10:35:59',
      'updated_at' => '2025-03-19 09:06:28',
    ]);


    // Insert default about content
    DB::table('categories')->insert([
      'id' => 3,
      'c_name' => 'Cleaning',
      'img' => '1739279794.png',
      'status' => 1,
      'created_at' => '2024-09-24 10:35:59',
      'updated_at' => '2025-03-19 09:06:28',
    ]);


    // Insert default about content
    DB::table('categories')->insert([
      'id' => 4,
      'c_name' => 'Plumber',
      'img' => '1739279762.png',
      'status' => 1,
      'created_at' => '2024-09-24 10:35:59',
      'updated_at' => '2025-03-19 09:06:28',
    ]);



    // Insert default about content
    DB::table('categories')->insert([
      'id' => 5,
      'c_name' => 'Electrician',
      'img' => '1739279638.png',
      'status' => 1,
      'created_at' => '2024-09-24 10:35:59',
      'updated_at' => '2025-03-19 09:06:28',
    ]);


    // Insert default about content
    DB::table('categories')->insert([
      'id' => 6,
      'c_name' => 'Camera Service',
      'img' => '1739279443.png',
      'status' => 1,
      'created_at' => '2024-09-24 10:35:59',
      'updated_at' => '2025-03-19 09:06:28',
    ]);


    // Insert default about content
    DB::table('categories')->insert([
      'id' => 7,
      'c_name' => 'Pest Control',
      'img' => '1740655460.png',
      'status' => 1,
      'created_at' => '2024-09-24 10:35:59',
      'updated_at' => '2025-03-19 09:06:28',
    ]);


    // Insert default about content
    DB::table('categories')->insert([
      'id' => 8,
      'c_name' => 'Salon',
      'img' => '1740655528.png',
      'status' => 1,
      'created_at' => '2024-09-24 10:35:59',
      'updated_at' => '2025-03-19 09:06:28',
    ]);
  }


  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('categories');
  }
};
