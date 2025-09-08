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
    Schema::create('payment_gateway_key', function (Blueprint $table) {
      $table->increments('id');
      $table->string('text')->nullable();
      $table->string('public_key')->nullable();
      $table->string('secret_key')->nullable();
      $table->string('mode')->nullable();
      $table->integer('status')->default(1);
      $table->text('country_code')->nullable();
      $table->text('currency_code')->nullable();
      $table->timestamps();
    });


    // Insert default about content
    DB::table('payment_gateway_key')->insert([
      'id' => 1,
      'text' => 'Razor Pay',
      'public_key' => 'rzp_test_ktbxSvVI7dsfn2',
      'secret_key' => 'bV0o6z2nrLvgSmiA1eIMCGYx',
      'mode' => "Test",
      'status' => 1,
      'country_code' => null,
      'currency_code' => null,
      'created_at' => '2024-09-24 10:35:59',
      'updated_at' => '2025-03-19 09:06:28',
    ]);



    // Insert default about content
    DB::table('payment_gateway_key')->insert([
      'id' => 2,
      'text' => 'Flutterwave',
      'public_key' => 'FLWPUBK_TEST-913aba0b972e0e9ae97f83096a7a4b1b-X',
      'secret_key' => 'FLWPUBK_TEST-913aba0b972e0e9ae97f83096a7a4b1b-X',
      'mode' => "Test",
      'status' => 1,
      'country_code' => null,
      'currency_code' => null,
      'created_at' => '2024-09-24 10:35:59',
      'updated_at' => '2025-03-19 09:06:28',
    ]);



    // Insert default about content
    DB::table('payment_gateway_key')->insert([
      'id' => 3,
      'text' => 'Stripe',
      'public_key' => 'pk_test_51PsekSRobaUvqlpAJiVa2ebFH3hZDVrWLHpDShQ0KkSDgL6lv2gIlYRriECu5zo3ALwugfl410c4dLRy108i9xhg00j4A65mSz',
      'secret_key' => 'sk_test_51PsekSRobaUvqlpAECJR9kEQEpoWi8c0uK0RIeTQSZyl29PNqU5tEJo5Jr5lfqvLcMF2ewD1AIRDQCun53sbLxvu00j7UWkC8u',
      'mode' => "Test",
      'status' => 1,
      'country_code' => null,
      'currency_code' => null,
      'created_at' => '2024-09-24 10:35:59',
      'updated_at' => '2025-03-19 09:06:28',
    ]);


    // Insert default about content
    DB::table('payment_gateway_key')->insert([
      'id' => 4,
      'text' => 'Paypal',
      'public_key' => 'AVzMVWctLyouPgmfv9Nh6E5KakydG4JHiFGm-fgg6HRqFYUW-gHVKS1ebRfPgDOr2uYABGGcnU_3RaSL',
      'secret_key' => 'EGWCyNAp9oTXjlmckT8DO9lepyKFrWQy2KvPPmrUsard4K98fuArUYbFQl7CaHdhk4Ehdg_hPkToods4',
      'mode' => "Live",
      'status' => 1,
      'country_code' => null,
      'currency_code' => null,
      'created_at' => '2024-09-24 10:35:59',
      'updated_at' => '2025-03-19 09:06:28',
    ]);


    // Insert default about content
    DB::table('payment_gateway_key')->insert([
      'id' => 5,
      'text' => 'Google Pay',
      'public_key' => '12345678901234567890',
      'secret_key' => 'My Dynamic Merchant',
      'mode' => "Test",
      'status' => 1,
      'country_code' => 'US',
      'currency_code' => "USD",
      'created_at' => '2024-09-24 10:35:59',
      'updated_at' => '2025-03-19 09:06:28',
    ]);



    // Insert default about content
    DB::table('payment_gateway_key')->insert([
      'id' => 6,
      'text' => 'Wallet',
      'public_key' => null,
      'secret_key' => null,
      'mode' => null,
      'status' => 1,
      'country_code' => null,
      'currency_code' => null,
      'created_at' => '2024-09-24 10:35:59',
      'updated_at' => '2025-03-19 09:06:28',
    ]);



    // Insert default about content
    DB::table('payment_gateway_key')->insert([
      'id' => 7,
      'text' => 'Applepay',
      'public_key' => 'merchant.com.primocys.hmuserapp',
      'secret_key' => "Sam's Fish",
      'mode' => "Test",
      'status' => 1,
      'country_code' => 'US',
      'currency_code' => "USD",
      'created_at' => '2024-09-24 10:35:59',
      'updated_at' => '2025-03-19 09:06:28',
    ]);
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('payment_gateway_key');
  }
};
