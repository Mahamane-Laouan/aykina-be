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
    Schema::create('services', function (Blueprint $table) {
      $table->increments('id');
      $table->integer('cat_id')->nullable();
      $table->string('res_id')->nullable();
      $table->integer('v_id')->nullable();
      $table->text('service_name')->nullable();
      $table->text('service_price')->nullable();
      $table->text('service_discount_price')->nullable();
      $table->text('service_description')->nullable();
      $table->text('service_image')->nullable();
      $table->string('service_phone')->nullable();
      $table->string('duration')->nullable();
      $table->string('service_ratings')->default('0.0');
      $table->string('is_features')->default('0');
      $table->integer('status')->default(0);
      $table->text('product_id')->nullable();
      $table->string('is_delete')->default('0');
      $table->text('meta_title')->nullable();
      $table->text('meta_description')->nullable();
      $table->string('lat')->nullable();
      $table->string('lon')->nullable();
      $table->text('address')->nullable();
      $table->timestamps(); // created_at & updated_at
    });
  }


  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('services');
  }
};
