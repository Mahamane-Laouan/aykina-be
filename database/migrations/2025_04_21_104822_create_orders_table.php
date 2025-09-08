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
    Schema::create('orders', function (Blueprint $table) {
      $table->increments('id');
      $table->string('order_id')->nullable();
      $table->unsignedInteger('user_id');
      $table->string('total')->default('0')->nullable();
      $table->string('product_subtotal')->nullable();
      $table->string('service_subtotal')->nullable();
      $table->string('sub_total')->nullable();
      $table->string('mrp_sub_total')->nullable();
      $table->string('service_id')->nullable();
      $table->string('product_id')->nullable();
      $table->string('coupon')->nullable();
      $table->string('coupon_type')->nullable();
      $table->string('coupon_percentage')->nullable();
      $table->string('tax')->nullable();
      $table->string('service_charge')->nullable();
      $table->string('shipping_charge')->default('0')->nullable();
      $table->mediumText('items')->nullable();
      $table->mediumText('payment_mode')->nullable();
      $table->text('address')->nullable();
      $table->string('number')->nullable();
      $table->mediumText('date')->nullable();
      $table->date('datea')->nullable();
      $table->mediumText('txn_id')->nullable();
      $table->integer('p_status')->nullable();
      $table->mediumText('p_date')->nullable();
      $table->integer('order_status')->default(0)->nullable();
      $table->string('sales_id')->nullable();
      $table->integer('erning_status')->default(0)->comment('driver earning status')->nullable();
      $table->string('order_otp')->nullable();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('orders');
  }
};
