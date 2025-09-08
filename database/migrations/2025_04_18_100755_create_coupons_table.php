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
    Schema::create('coupons', function (Blueprint $table) {
      $table->id();
      $table->text('code')->nullable();
      $table->text('discount')->nullable();
      $table->text('type');
      $table->text('coupon_for');
      $table->integer('status')->nullable()->default(0);
      $table->dateTime('expire_date')->default(DB::raw('CURRENT_TIMESTAMP'));
      $table->text('description')->nullable();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('coupons');
  }
};
