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
    Schema::create('mail_setup', function (Blueprint $table) {
      $table->increments('id'); // Auto-incrementing primary key
      $table->text('mail_mailer')->nullable(); // Mailer setting
      $table->text('mail_host')->nullable(); // Mail host
      $table->text('mail_port')->nullable(); // Mail port
      $table->text('mail_encryption')->nullable(); // Encryption method
      $table->text('mail_username')->nullable(); // Mail username
      $table->text('mail_password')->nullable(); // Mail password
      $table->text('mail_from')->nullable(); // 'From' address for mail
      $table->timestamps(); // created_at and updated_at timestamps
    });


    // Insert default about content
    DB::table('mail_setup')->insert([
      'id' => 1,
      'mail_mailer' => null,
      'mail_host' => null,
      'mail_port' => null,
      'mail_encryption' => null,
      'mail_username' => null,
      'mail_password' => null,
      'mail_from' => null,
      'created_at' => '2024-09-24 10:35:59',
      'updated_at' => '2025-03-19 09:06:28',
    ]);
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('mail_setup');
  }
};
