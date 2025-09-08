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
    Schema::create('theme_setup', function (Blueprint $table) {
      $table->increments('id');
      $table->text('logo')->nullable();
      $table->text('footer_logo')->nullable();
      $table->text('fav_icon')->nullable();
      $table->text('color_code')->nullable();
      $table->timestamp('created_at')->nullable();
      $table->timestamp('updated_at')->nullable();
    });


    // Insert default about content
    DB::table('theme_setup')->insert([
      'id' => 1,
      'logo' => '1735637557_logo_6773ba351ed3f.jpg',
      'footer_logo' => '1735637557_footer_6773ba351ef61.jpg',
      'fav_icon' => '1735637557_favicon_6773ba351f0bf.jpg',
      'color_code' => '#1f58c7',
      'created_at' => '2024-09-24 10:35:59',
      'updated_at' => '2025-03-19 09:06:28',
    ]);
  }


  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('theme_setup');
  }
};
