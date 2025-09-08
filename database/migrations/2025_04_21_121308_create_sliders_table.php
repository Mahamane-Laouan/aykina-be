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
    Schema::create('sliders', function (Blueprint $table) {
      $table->increments('id');
      $table->string('slider_name'); // varchar(255)
      $table->integer('service_id'); // int(11)
      $table->string('slider_image'); // varchar(255)
      $table->text('slider_description'); // text
      $table->integer('status')->default(0); // int(11)
      $table->timestamps(0); // created_at & updated_at with current_timestamp
    });
  }


  /**
   * Reverse the migrations.
   */
    public function down(): void
    {
        Schema::dropIfExists('sliders');
    }
};
