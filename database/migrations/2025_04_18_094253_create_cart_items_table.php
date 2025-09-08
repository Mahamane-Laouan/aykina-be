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
    Schema::create('cart_items', function (Blueprint $table) {
      $table->integer('cart_id', false, true)->length(11)->autoIncrement();  // Primary int(11) UNSIGNED auto-increment
      $table->integer('user_id', false, true)->length(11);
      $table->integer('provider_id', false, true)->length(11)->nullable();
      $table->integer('product_id', false, true)->length(11)->nullable();
      $table->string('service_id', 255)->nullable()->charset('latin1')->collation('latin1_swedish_ci');
      $table->string('addon_service_id', 255)->nullable()->charset('latin1')->collation('latin1_swedish_ci');
      $table->integer('quantity', false, true)->length(11)->nullable();
      $table->integer('price', false, true)->length(11)->nullable();
      $table->integer('shipping_charge', false, true)->length(11)->nullable();
      $table->string('coupon_code', 255)->nullable()->charset('latin1')->collation('latin1_swedish_ci');
      $table->boolean('checked')->default(0);  // tinyint(1)
      $table->integer('address_id', false, true)->length(11)->nullable()->default(0);
      $table->integer('order_id', false, true)->length(11)->nullable();
      $table->integer('order_status', false, true)->length(11)->default(0);
      $table->text('booking_date')->nullable()->charset('latin1')->collation('latin1_swedish_ci');
      $table->text('booking_time')->nullable()->charset('latin1')->collation('latin1_swedish_ci');
      $table->text('notes')->nullable()->charset('latin1')->collation('latin1_swedish_ci');
      $table->string('coupon_type', 255)->nullable()->charset('latin1')->collation('latin1_swedish_ci');
      $table->string('coupon_percentage', 255)->nullable()->charset('latin1')->collation('latin1_swedish_ci');
      $table->timestamps();  // created_at, updated_at
    });
  }


  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('cart_items');
  }
};
