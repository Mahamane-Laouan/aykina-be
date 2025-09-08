<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  /**
   * Run the migrations.
   */
  public function up()
  {
    Schema::create('user_addresses', function (Blueprint $table) {
      $table->increments('address_id');
      $table->integer('user_id');
      $table->string('full_name');
      $table->string('phone');
      $table->string('address')->nullable();
      $table->string('address_type')->nullable();
      $table->string('landmark')->nullable();
      $table->mediumText('city')->nullable();
      $table->string('state', 100)->nullable();
      $table->string('area_name')->nullable();
      $table->string('country', 100)->nullable();
      $table->string('zip_code', 12)->nullable();
      $table->text('country_code')->nullable();
      $table->text('country_flag')->nullable();
      $table->string('lat')->nullable();
      $table->string('lon')->nullable();
      $table->tinyInteger('as_default')->default(0);
      $table->string('is_delete')->default(0);
      $table->timestamps();
    });
  }


  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('user_addresses');
  }
};
