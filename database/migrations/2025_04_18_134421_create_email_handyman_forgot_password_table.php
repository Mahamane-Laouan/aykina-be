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
    Schema::create('email_handyman_forgot_password', function (Blueprint $table) {
      $table->id();
      $table->text('logo')->nullable();
      $table->text('title')->nullable();
      $table->text('body')->nullable();
      $table->text('section_text')->nullable();
      $table->integer('privacy_policy')->default(0)->nullable();
      $table->integer('refund_policy')->default(0)->nullable();
      $table->integer('cancellation_policy')->default(0)->nullable();
      $table->integer('contact_us')->default(0)->nullable();
      $table->integer('twitter')->default(0)->nullable();
      $table->integer('linkedIn')->default(0)->nullable();
      $table->integer('instagram')->default(0)->nullable();
      $table->integer('facebook')->default(0)->nullable();
      $table->text('copyright_content')->nullable();
      $table->integer('get_email')->default(1);
      $table->timestamps();
    });


    // Insert default about content
    DB::table('email_handyman_forgot_password')->insert([
      'id' => 1,
      'logo' => '1739969361.jpg',
      'title' => 'Change Password Request',
      'body' => 'Your verification code for password change is',
      'section_text' => "Please contact us for any queries. We're always happy to help.",
      'privacy_policy' => 1,
      'refund_policy' => 1,
      'cancellation_policy' => 1,
      'contact_us' => 1,
      'twitter' => 1,
      'linkedIn' => 1,
      'instagram' => 1,
      'facebook' => 1,
      'copyright_content' => '2025 handyman. All rights reserved.',
      'get_email' => 1,
      'created_at' => '2024-09-24 10:35:59',
      'updated_at' => '2025-03-19 09:06:28',
    ]);
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('email_handyman_forgot_password');
  }
};
