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
    Schema::create('email_provider_booking_completed', function (Blueprint $table) {
      $table->id(); // auto_increment primary key 'id'
      $table->text('logo')->nullable(); // column for logo
      $table->text('title')->nullable(); // column for title
      $table->text('body')->nullable(); // column for body content
      $table->text('section_text')->nullable(); // column for section_text
      $table->integer('privacy_policy')->default(0)->nullable(); // privacy_policy as int(11) with default value 0
      $table->integer('refund_policy')->default(0)->nullable(); // refund_policy as int(11) with default value 0
      $table->integer('cancellation_policy')->default(0)->nullable(); // cancellation_policy as int(11) with default value 0
      $table->integer('contact_us')->default(0)->nullable(); // contact_us as int(11) with default value 0
      $table->integer('twitter')->default(0)->nullable(); // twitter as int(11) with default value 0
      $table->integer('linkedIn')->default(0)->nullable(); // linkedIn as int(11) with default value 0
      $table->integer('instagram')->default(0)->nullable(); // instagram as int(11) with default value 0
      $table->integer('facebook')->default(0)->nullable(); // facebook as int(11) with default value 0
      $table->text('copyright_content')->nullable(); // column for copyright content
      $table->integer('get_email')->default(1); // get_email as int(11) with default value 1
      $table->timestamps(); // created_at and updated_at timestamps
    });


    // Insert default about content
    DB::table('email_provider_booking_completed')->insert([
      'id' => 1,
      'logo' => '1739968864.jpg',
      'title' => 'Booking Completed',
      'body' => 'Booking of service [[service_name]] has been completed by [[handyman_name]] of booking [[booking_id]]. Thank you for choosing our service.',
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
    Schema::dropIfExists('email_provider_booking_completed');
  }
};
