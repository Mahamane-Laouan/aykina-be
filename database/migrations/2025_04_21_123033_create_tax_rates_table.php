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
    Schema::create('tax_rates', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->string('name');
      $table->string('zone_id')->nullable(); // If this is foreign, consider using unsignedBigInteger + FK constraint
      $table->string('tax_rate'); // Storing as string; if it's a float, you can use $table->decimal('tax_rate', 8, 2);
      $table->string('type'); // Example: "0" = fixed, "1" = percentage
      $table->integer('status');
      $table->timestamp('created_at')->nullable();
      $table->timestamp('updated_at')->nullable();
    });

    // Insert default about content
    DB::table('tax_rates')->insert([
      'id' => 1,
      'name' => 'GST',
      'zone_id' => '4',
      'tax_rate' => '18.5',
      'type' => '1',
      'status' => 1,
      'created_at' => '2024-09-24 10:35:59',
      'updated_at' => '2025-03-19 09:06:28',
    ]);



    // Insert default about content
    DB::table('tax_rates')->insert([
      'id' => 2,
      'name' => 'VGST2025',
      'zone_id' => '5',
      'tax_rate' => '18.5',
      'type' => '1',
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
    Schema::dropIfExists('tax_rates');
  }
};
