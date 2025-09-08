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
    Schema::create('language', function (Blueprint $table) {
      $table->increments('id'); // Auto-incrementing primary key
      $table->string('name', 255)->nullable(); // Language name
      $table->string('text', 255)->nullable(); // Text in the language
      $table->text('image')->nullable(); // Image associated with the language
      $table->timestamps(); // created_at and updated_at timestamps
    });
  }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('language');
    }
};
