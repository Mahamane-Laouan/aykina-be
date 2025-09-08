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
    Schema::create('commissions', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('people_id')->nullable();
      $table->string('user_role')->nullable();
      $table->string('value')->nullable();
      $table->string('type')->nullable();
      $table->timestamps();
    });

    // Insert default about content
    DB::table('commissions')->insert([
      'id' => 1,
      'people_id' => 2,
      'user_role' => 'Handyman',
      'value' => '20',
      'type' => 'Service',
      'created_at' => '2024-09-24 10:35:59',
      'updated_at' => '2025-03-19 09:06:28',
    ]);


    // Insert default about content
    DB::table('commissions')->insert([
      'id' => 2,
      'people_id' => 1,
      'user_role' => 'Provider',
      'value' => '30',
      'type' => 'Service',
      'created_at' => '2024-09-24 10:35:59',
      'updated_at' => '2025-03-19 09:06:28',
    ]);


    // Insert default about content
    DB::table('commissions')->insert([
      'id' => 3,
      'people_id' => 1,
      'user_role' => 'Provider',
      'value' => '90',
      'type' => 'Product',
      'created_at' => '2024-09-24 10:35:59',
      'updated_at' => '2025-03-19 09:06:28',
    ]);
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('commissions');
  }
};
