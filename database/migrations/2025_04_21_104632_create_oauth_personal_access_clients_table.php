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
    Schema::create('oauth_personal_access_clients', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->unsignedBigInteger('client_id');
      $table->timestamp('created_at')->nullable();
      $table->timestamp('updated_at')->nullable();

      // Optional foreign key constraint (if oauth_clients is used)
      // $table->foreign('client_id')->references('id')->on('oauth_clients')->onDelete('cascade');
    });
  }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('oauth_personal_access_clients');
    }
};
