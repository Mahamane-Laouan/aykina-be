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
    Schema::create('currencies', function (Blueprint $table) {
      $table->id();
      $table->text('currency')->nullable();
      $table->text('name')->nullable();
      $table->timestamps();
    });

    // Insert default about content
    DB::table('currencies')->insert([
      'id' => 1,
      'currency' => '€',
      'name' => 'EUR',
      'created_at' => '2024-09-24 10:35:59',
      'updated_at' => '2025-03-19 09:06:28',
    ]);

    // Insert default about content
    DB::table('currencies')->insert([
      'id' => 2,
      'currency' => '£',
      'name' => 'GBP',
      'created_at' => '2024-09-24 10:35:59',
      'updated_at' => '2025-03-19 09:06:28',
    ]);

    // Insert default about content
    DB::table('currencies')->insert([
      'id' => 3,
      'currency' => '₹',
      'name' => 'INR',
      'created_at' => '2024-09-24 10:35:59',
      'updated_at' => '2025-03-19 09:06:28',
    ]);

    // Insert default about content
    DB::table('currencies')->insert([
      'id' => 4,
      'currency' => 'A$',
      'name' => 'AUD',
      'created_at' => '2024-09-24 10:35:59',
      'updated_at' => '2025-03-19 09:06:28',
    ]);

    // Insert default about content
    DB::table('currencies')->insert([
      'id' => 5,
      'currency' => '$',
      'name' => 'USD',
      'created_at' => '2024-09-24 10:35:59',
      'updated_at' => '2025-03-19 09:06:28',
    ]);
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('currencies');
  }
};
