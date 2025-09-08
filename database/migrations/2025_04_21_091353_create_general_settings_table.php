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
    Schema::create('general_settings', function (Blueprint $table) {
      $table->increments('id');
      $table->text('name')->nullable();
      $table->text('email')->nullable();
      $table->text('phone')->nullable();
      $table->text('website')->nullable();
      $table->text('country')->nullable();
      $table->text('state')->nullable();
      $table->text('city')->nullable();
      $table->text('zipcode')->nullable();
      $table->text('address')->nullable();
      $table->text('description')->nullable();
      $table->timestamps();
    });


    // Insert default about content
    DB::table('general_settings')->insert([
      'id' => 1,
      'name' => 'Handyman App',
      'email' => 'hello@iqonic.design',
      'phone' => '+15265897485',
      'website' => "https://apps.iqonic.design/handyman/",
      'country' => "United States",
      'state' => 'New York',
      'city' => 'Albany',
      'zipcode' => '12201',
      'address' => '45 HUDSON AVE UNIT 1296 ALBANY NY 12201-6256 USA',
      'description' => 'Launch your own mobile-based online On-Demand Home Services with Handyman Service mobile app. The customizable templates of this amazing app can quickly let developers to set up a service booking system to accept bookings from clients from anywhere in only a few minutes. With ready to use Sign in page, Sign up pages, Payment methods page, Booking lists, Service Type demo, Handyman detail page, Coupon page, and more, this Handyman Service app allows business to have a complete and running booking service system app in no time.The provider in this Handyman Service app can assign the booking to Handyman and accelerate the service. This Handyman Service system app comes with a Laravel PHP admin panel to have a meaningful insights from the admin dashboard and statistics. Assign multi-roles and permissions like Admin, Service Provider, Handyman, and customers using this app. Additionally, this Handyman Service app supports Multiple Language/ RTL support. This customizable, ready-to-use app comes with light as well as dark theme support and push notification to engage with clients in a more interactive way.',
      'created_at' => '2024-09-24 10:35:59',
      'updated_at' => '2025-03-19 09:06:28',
    ]);
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('general_settings');
  }
};
