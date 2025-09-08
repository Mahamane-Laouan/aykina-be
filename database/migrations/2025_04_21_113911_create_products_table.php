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
        Schema::create('products', function (Blueprint $table) {
            $table->increments('product_id');
            $table->unsignedInteger('vid')->nullable();
            $table->unsignedInteger('cat_id')->nullable();
            $table->string('service_id')->nullable();
            $table->text('product_name')->nullable();
            $table->mediumText('product_description')->nullable();
            $table->string('product_price', 100)->nullable();
            $table->string('product_discount_price', 255)->nullable();
            $table->text('product_image')->nullable();
            $table->string('pro_ratings', 255)->default('0.0');
            $table->text('size')->nullable();
            $table->text('colors')->nullable();
            $table->text('weight')->nullable();
            $table->string('status')->nullable();
            $table->string('is_features')->default('0');
            $table->string('is_delete')->default('0');
            $table->dateTime('product_create_date')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
