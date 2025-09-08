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
    Schema::create('cancel_policy', function (Blueprint $table) {
      $table->integer('id', false, true)->length(11)->autoIncrement();  // Primary int(11) UNSIGNED auto-increment
      $table->text('text')->nullable();
      $table->timestamps();  // This will create created_at and updated_at columns
    });

    // Insert default about content
    DB::table('cancel_policy')->insert([
      'id' => 1,
      'text' => "<h1><strong><em><u>Cancellation Policy</u></em></strong></h1><p>Updated at 04, Oct 2024</p><p><br></p><h2><strong><em><u>General Terms</u></em></strong></h2><p>By accessing and placing an order with , you confirm that you are in agreement with and bound by the terms of service contained in the Terms &amp; Conditions outlined below. These terms apply to the entire website and any email or other type of communication between you and .</p><p>Under no circumstances shall team be liable for any direct, indirect, special, incidental or consequential damages, including, but not limited to, loss of data or profit, arising out of the use, or the inability to use, the materials on this site, even if team or an authorized representative has been advised of the possibility of such damages. If your use of materials from this site results in the need for servicing, repair or correction of equipment or data, you assume any costs thereof.</p><p>will not be responsible for any outcome that may occur during the course of usage of our resources. We reserve the rights to change prices and revise the resources usage policy in any moment.</p><p><br></p><h2>Contact Us</h2><p>Don't hesitate to contact us if you have any questions.</p><ul><li>Via Email: info@primocys.com</li></ul>",
      'created_at' => '2024-09-24 10:35:59',
      'updated_at' => '2025-03-19 09:06:28',
    ]);
  }


  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('cancel_policy');
  }
};
