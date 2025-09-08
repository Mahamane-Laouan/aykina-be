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
    Schema::create('notification_permissions', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->string('name')->nullable();
      $table->string('label')->nullable();
      $table->string('title')->nullable();
      $table->longText('description')->nullable();
      $table->string('type')->nullable();
      $table->string('role_type')->nullable();
      $table->longText('to')->nullable();
      $table->longText('bcc')->nullable();
      $table->longText('cc')->nullable();
      $table->tinyInteger('status')->default(0);
      $table->string('channels')->nullable();
      $table->unsignedInteger('created_by')->nullable();
      $table->unsignedInteger('updated_by')->nullable();
      $table->unsignedInteger('deleted_by')->nullable();
      $table->text('notify_desc')->nullable();
      $table->timestamps();
      $table->timestamp('deleted_at')->nullable();
    });

    // Insert default about content
    DB::table('notification_permissions')->insert([
      'id' => 1,
      'name' => 'add_bookings',
      'label' => 'Booking confirmation',
      'title' => 'Order Placed Successful',
      'description' => "Your Booking ID [[ booking_id ]] has been placed successfully.",
      'type' => 'add_booking',
      'role_type' => 'User',
      'to' => '["admin","provider"]',
      'bcc' => null,
      'cc' => null,
      'status' => 1,
      'channels' => '{"IS_MAIL":"1","PUSH_NOTIFICATION":"1"}',
      'created_by' => null,
      'updated_by' => null,
      'deleted_by' => null,
      'notify_desc' => 'Order Placed Successfully By Customer',
      'created_at' => '2024-04-05 11:39:18',
      'updated_at' => '2025-02-13 13:14:09',
      'deleted_at' => null,
    ]);



    // Insert default about content
    DB::table('notification_permissions')->insert([
      'id' => 4,
      'name' => 'update_booking_status',
      'label' => 'Update Booking',
      'title' => 'Booking Accepted',
      'description' => "Booking id [[ booking_id ]] has been updated from Pending to Accepted.",
      'type' => 'update_booking_status',
      'role_type' => 'User',
      'to' => '["admin", "provider" , "handyman" , "user"]',
      'bcc' => null,
      'cc' => null,
      'status' => 1,
      'channels' => '{"IS_MAIL":"1","PUSH_NOTIFICATION":"1"}',
      'created_by' => null,
      'updated_by' => null,
      'deleted_by' => null,
      'notify_desc' => 'Booking Updated From Pending to Accepted.',
      'created_at' => '2024-04-05 11:39:18',
      'updated_at' => '2025-02-13 13:14:09',
      'deleted_at' => null,
    ]);


    // Insert default about content
    DB::table('notification_permissions')->insert([
      'id' => 5,
      'name' => 'cancel_booking',
      'label' => 'Cancel On Booking',
      'title' => 'Booking Cancelled',
      'description' => "Booking ID [[ booking_id ]] has been Cancelled by [[ user_name ]].",
      'type' => 'cancel_booking',
      'role_type' => 'User',
      'to' => '["admin", "provider" , "handyman" , "user"]',
      'bcc' => null,
      'cc' => null,
      'status' => 1,
      'channels' => '{"IS_MAIL":"1","PUSH_NOTIFICATION":"1"}',
      'created_by' => null,
      'updated_by' => null,
      'deleted_by' => null,
      'notify_desc' => 'Booking Gets Cancelled by Customer',
      'created_at' => '2024-04-05 11:39:18',
      'updated_at' => '2025-02-13 13:14:09',
      'deleted_at' => null,
    ]);


    // Insert default about content
    DB::table('notification_permissions')->insert([
      'id' => 20,
      'name' => 'order_otp_check',
      'label' => 'Update Booking',
      'title' => 'Booking Start',
      'description' => "Your Booking ID [[ booking_id ]] has been start.",
      'type' => 'update_booking_status',
      'role_type' => 'User',
      'to' => null,
      'bcc' => null,
      'cc' => null,
      'status' => 1,
      'channels' => null,
      'created_by' => null,
      'updated_by' => null,
      'deleted_by' => null,
      'notify_desc' => 'Booking Started by The Handyman',
      'created_at' => '2024-04-05 11:39:18',
      'updated_at' => '2025-02-13 13:14:09',
      'deleted_at' => null,
    ]);



    // Insert default about content
    DB::table('notification_permissions')->insert([
      'id' => 22,
      'name' => 'product_delivered',
      'label' => 'Product Delivered',
      'title' => 'Product Delivered',
      'description' => "Your Product Order ID [[ booking_id ]] is Successfully Delivered.",
      'type' => 'product_delivered',
      'role_type' => 'User',
      'to' => null,
      'bcc' => null,
      'cc' => null,
      'status' => 1,
      'channels' => null,
      'created_by' => null,
      'updated_by' => null,
      'deleted_by' => null,
      'notify_desc' => 'Product Delivered by Provider',
      'created_at' => '2024-04-05 11:39:18',
      'updated_at' => '2025-02-13 13:14:09',
      'deleted_at' => null,
    ]);



    // Insert default about content
    DB::table('notification_permissions')->insert([
      'id' => 23,
      'name' => 'order_received',
      'label' => 'Order Received',
      'title' => 'New Booking Received',
      'description' => "New booking ID [[ booking_id ]] has booked [[ booking_services_name ]] by [[ customer_name ]].",
      'type' => 'order_received',
      'role_type' => 'Provider',
      'to' => null,
      'bcc' => null,
      'cc' => null,
      'status' => 1,
      'channels' => null,
      'created_by' => null,
      'updated_by' => null,
      'deleted_by' => null,
      'notify_desc' => 'Booking Received to Provider',
      'created_at' => '2024-04-05 11:39:18',
      'updated_at' => '2025-02-13 13:14:09',
      'deleted_at' => null,
    ]);



    // Insert default about content
    DB::table('notification_permissions')->insert([
      'id' => 24,
      'name' => 'handyman_arrived',
      'label' => 'Update Booking',
      'title' => 'Booking In Progress',
      'description' => "Booking id [[ booking_id ]] has been updated from Accepted to In Progress.",
      'type' => 'handyman_arrived',
      'role_type' => 'User,Provider',
      'to' => null,
      'bcc' => null,
      'cc' => null,
      'status' => 1,
      'channels' => null,
      'created_by' => null,
      'updated_by' => null,
      'deleted_by' => null,
      'notify_desc' => 'Booking Updated from Accepted to In Progress.',
      'created_at' => '2024-04-05 11:39:18',
      'updated_at' => '2025-02-13 13:14:09',
      'deleted_at' => null,
    ]);



    // Insert default about content
    DB::table('notification_permissions')->insert([
      'id' => 25,
      'name' => 'handyman_complete_work',
      'label' => 'Update Booking',
      'title' => 'Booking Completed',
      'description' => "Booking id [[ booking_id ]] has been Updated from In Progress to Completed.",
      'type' => 'handyman_complete_work',
      'role_type' => 'User,Provider',
      'to' => null,
      'bcc' => null,
      'cc' => null,
      'status' => 1,
      'channels' => null,
      'created_by' => null,
      'updated_by' => null,
      'deleted_by' => null,
      'notify_desc' => 'Booking Updated From In Progress to Completed',
      'created_at' => '2024-04-05 11:39:18',
      'updated_at' => '2025-02-13 13:14:09',
      'deleted_at' => null,
    ]);


    // Insert default about content
    DB::table('notification_permissions')->insert([
      'id' => 26,
      'name' => 'handyman_cancel_booking',
      'label' => 'Update Booking',
      'title' => 'Booking Cancelled',
      'description' => "Booking ID [[ booking_id ]] has been Cancelled by [[ handyman_name ]]",
      'type' => 'handyman_cancel_booking',
      'role_type' => 'User,Provider',
      'to' => null,
      'bcc' => null,
      'cc' => null,
      'status' => 1,
      'channels' => null,
      'created_by' => null,
      'updated_by' => null,
      'deleted_by' => null,
      'notify_desc' => 'Booking Rejected by Handyman',
      'created_at' => '2024-04-05 11:39:18',
      'updated_at' => '2025-02-13 13:14:09',
      'deleted_at' => null,
    ]);



    // Insert default about content
    DB::table('notification_permissions')->insert([
      'id' => 27,
      'name' => 'user_cancel_booking',
      'label' => 'Cancel Booking',
      'title' => 'Cancel Booking',
      'description' => "booking has been Cancelled by [[ handyman_name ]].",
      'type' => 'user_cancel_booking',
      'role_type' => 'Provider',
      'to' => null,
      'bcc' => null,
      'cc' => null,
      'status' => 1,
      'channels' => null,
      'created_by' => null,
      'updated_by' => null,
      'deleted_by' => null,
      'notify_desc' => 'Booking Cancelled by Handyman',
      'created_at' => '2024-04-05 11:39:18',
      'updated_at' => '2025-02-13 13:14:09',
      'deleted_at' => null,
    ]);



    // Insert default about content
    DB::table('notification_permissions')->insert([
      'id' => 28,
      'name' => 'handyman_hold_booking',
      'label' => 'Hold Booking',
      'title' => 'Booking Hold',
      'description' => "Booking ID [[ booking_id ]] has been Hold by [[ handyman_name ]]",
      'type' => 'handyman_hold_booking',
      'role_type' => 'User,Provider',
      'to' => null,
      'bcc' => null,
      'cc' => null,
      'status' => 1,
      'channels' => null,
      'created_by' => null,
      'updated_by' => null,
      'deleted_by' => null,
      'notify_desc' => 'Booking Has Been Hold by Handyman',
      'created_at' => '2024-04-05 11:39:18',
      'updated_at' => '2025-02-13 13:14:09',
      'deleted_at' => null,
    ]);



    // Insert default about content
    DB::table('notification_permissions')->insert([
      'id' => 29,
      'name' => 'handyman_assigned_booking',
      'label' => 'Assigned Booking',
      'title' => 'Booking Assigned',
      'description' => "You have received New Booking ID [[ booking_id ]] of service [[ service_name ]].",
      'type' => 'handyman_assigned_booking',
      'role_type' => 'User,Handyman',
      'to' => null,
      'bcc' => null,
      'cc' => null,
      'status' => 1,
      'channels' => null,
      'created_by' => null,
      'updated_by' => null,
      'deleted_by' => null,
      'notify_desc' => 'Booking Assigned to Handyman',
      'created_at' => '2024-04-05 11:39:18',
      'updated_at' => '2025-02-13 13:14:09',
      'deleted_at' => null,
    ]);


    // Insert default about content
    DB::table('notification_permissions')->insert([
      'id' => 31,
      'name' => 'provider_cancel_booking',
      'label' => 'Cancel Booking',
      'title' => 'Booking Rejected',
      'description' => "Booking ID [[ booking_id ]] has been Rejected by [[ providername ]].",
      'type' => 'provider_cancel_booking',
      'role_type' => 'Provider',
      'to' => null,
      'bcc' => null,
      'cc' => null,
      'status' => 1,
      'channels' => null,
      'created_by' => null,
      'updated_by' => null,
      'deleted_by' => null,
      'notify_desc' => 'Booking Rejected by Provider',
      'created_at' => '2024-04-05 11:39:18',
      'updated_at' => '2025-02-13 13:14:09',
      'deleted_at' => null,
    ]);



    // Insert default about content
    DB::table('notification_permissions')->insert([
      'id' => 32,
      'name' => 'service_review',
      'label' => 'Service Review',
      'title' => 'Review for Service',
      'description' => "Booking ID [[ booking_id ]] has received [[ rating ]] star for [[ booking_service_name ]].",
      'type' => 'service_review',
      'role_type' => 'Provider,Handyman',
      'to' => null,
      'bcc' => null,
      'cc' => null,
      'status' => 1,
      'channels' => null,
      'created_by' => null,
      'updated_by' => null,
      'deleted_by' => null,
      'notify_desc' => 'Review for Service Provided by Customer',
      'created_at' => '2024-04-05 11:39:18',
      'updated_at' => '2025-02-13 13:14:09',
      'deleted_at' => null,
    ]);



    // Insert default about content
    DB::table('notification_permissions')->insert([
      'id' => 33,
      'name' => 'product_review',
      'label' => 'Product Review',
      'title' => 'Product Review',
      'description' => "[[ product_name ]] of [[ booking_id ]] has Received [[ rating ]] star.",
      'type' => 'product_review',
      'role_type' => 'Provider',
      'to' => null,
      'bcc' => null,
      'cc' => null,
      'status' => 1,
      'channels' => null,
      'created_by' => null,
      'updated_by' => null,
      'deleted_by' => null,
      'notify_desc' => 'Review for Product Provided by Customer',
      'created_at' => '2024-04-05 11:39:18',
      'updated_at' => '2025-02-13 13:14:09',
      'deleted_at' => null,
    ]);


    // Insert default about content
    DB::table('notification_permissions')->insert([
      'id' => 34,
      'name' => 'user_refund',
      'label' => 'User Refund',
      'title' => 'Refund Amount',
      'description' => "Refund Amount [[ service_name ]] [[ currency ]][[ amount ]] for Booking ID [[ booking_id ]] has been processed.",
      'type' => 'user_refund',
      'role_type' => 'User',
      'to' => null,
      'bcc' => null,
      'cc' => null,
      'status' => 1,
      'channels' => null,
      'created_by' => null,
      'updated_by' => null,
      'deleted_by' => null,
      'notify_desc' => 'Refund Amount Processed to Customer',
      'created_at' => '2024-04-05 11:39:18',
      'updated_at' => '2025-02-13 13:14:09',
      'deleted_at' => null,
    ]);

    // Insert default about content
    DB::table('notification_permissions')->insert([
      'id' => 35,
      'name' => 'product_in_progress',
      'label' => 'Product In Progress',
      'title' => 'Product In Progress',
      'description' => "Your Product Order ID [[ booking_id ]] is In Progress.",
      'type' => 'product_in_progress',
      'role_type' => 'Provider',
      'to' => null,
      'bcc' => null,
      'cc' => null,
      'status' => 1,
      'channels' => null,
      'created_by' => null,
      'updated_by' => null,
      'deleted_by' => null,
      'notify_desc' => 'Provider In Progress',
      'created_at' => '2024-04-05 11:39:18',
      'updated_at' => '2025-02-13 13:14:09',
      'deleted_at' => null,
    ]);



    // Insert default about content
    DB::table('notification_permissions')->insert([
      'id' => 36,
      'name' => 'handyman_rejeted',
      'label' => 'Update Booking',
      'title' => 'Booking Rejected',
      'description' => "Booking ID [[ booking_id ]] has been Rejected by [[ handyman_name ]]",
      'type' => 'handyman_reject_booking',
      'role_type' => 'User,Provider',
      'to' => null,
      'bcc' => null,
      'cc' => null,
      'status' => 1,
      'channels' => null,
      'created_by' => null,
      'updated_by' => null,
      'deleted_by' => null,
      'notify_desc' => 'Booking Rejected By Handyman',
      'created_at' => '2024-04-05 11:39:18',
      'updated_at' => '2025-02-13 13:14:09',
      'deleted_at' => null,
    ]);


    // Insert default about content
    DB::table('notification_permissions')->insert([
      'id' => 37,
      'name' => 'handyman_continue',
      'label' => 'Continue Booking',
      'title' => 'Booking Continue',
      'description' => "Booking ID [[ booking_id ]] has been updated from Hold to Continue by [[ handyman_name ]].",
      'type' => 'handyman_continue_booking',
      'role_type' => 'User,Provider',
      'to' => null,
      'bcc' => null,
      'cc' => null,
      'status' => 1,
      'channels' => null,
      'created_by' => null,
      'updated_by' => null,
      'deleted_by' => null,
      'notify_desc' => 'Booking Continue from Hold',
      'created_at' => '2024-04-05 11:39:18',
      'updated_at' => '2025-02-13 13:14:09',
      'deleted_at' => null,
    ]);



    // Insert default about content
    DB::table('notification_permissions')->insert([
      'id' => 38,
      'name' => 'update_booking_status',
      'label' => 'Update Booking',
      'title' => 'Booking Continue',
      'description' => "Booking ID [[ booking_id ]] has been Updated from in Progress to Completed.",
      'type' => 'update_booking_status',
      'role_type' => 'User',
      'to' => null,
      'bcc' => null,
      'cc' => null,
      'status' => 1,
      'channels' => null,
      'created_by' => null,
      'updated_by' => null,
      'deleted_by' => null,
      'notify_desc' => 'Booking Updated from in Progress to Completed.',
      'created_at' => '2024-04-05 11:39:18',
      'updated_at' => '2025-02-13 13:14:09',
      'deleted_at' => null,
    ]);



    // Insert default about content
    DB::table('notification_permissions')->insert([
      'id' => 39,
      'name' => 'payment_requests',
      'label' => 'Payment Request',
      'title' => 'Payment Request by Handyman',
      'description' => "Payment Request for [[ booking_services_name ]] for $[[ amount ]] by [[ handyman_name ]].",
      'type' => 'payment_requests',
      'role_type' => 'Provider',
      'to' => null,
      'bcc' => null,
      'cc' => null,
      'status' => 1,
      'channels' => null,
      'created_by' => null,
      'updated_by' => null,
      'deleted_by' => null,
      'notify_desc' => 'Payment Request Send by Handyman to Provider',
      'created_at' => '2024-04-05 11:39:18',
      'updated_at' => '2025-02-13 13:14:09',
      'deleted_at' => null,
    ]);



    // Insert default about content
    DB::table('notification_permissions')->insert([
      'id' => 40,
      'name' => 'payment_successful',
      'label' => 'Payment Successful',
      'title' => 'Payment Successful',
      'description' => "[[ booking_services_name ]] Payment Request has been sent of [[ currency ]][[ amount ]]",
      'type' => 'payment_requests',
      'role_type' => 'Handyman',
      'to' => null,
      'bcc' => null,
      'cc' => null,
      'status' => 1,
      'channels' => null,
      'created_by' => null,
      'updated_by' => null,
      'deleted_by' => null,
      'notify_desc' => 'Payment Sent Successfully',
      'created_at' => '2024-04-05 11:39:18',
      'updated_at' => '2025-02-13 13:14:09',
      'deleted_at' => null,
    ]);


    // Insert default about content
    DB::table('notification_permissions')->insert([
      'id' => 41,
      'name' => 'payment_requests_cancelled',
      'label' => 'Payment Request Cancelled',
      'title' => 'Payment Request Cancelled',
      'description' => "[[ booking_services_name ]] of Booking ID [[ booking_id ]] Payment Request has been cancelled $[[ amount ]]",
      'type' => 'payment_requests',
      'role_type' => 'Handyman',
      'to' => null,
      'bcc' => null,
      'cc' => null,
      'status' => 1,
      'channels' => null,
      'created_by' => null,
      'updated_by' => null,
      'deleted_by' => null,
      'notify_desc' => 'Payment Request Cancelled',
      'created_at' => '2024-04-05 11:39:18',
      'updated_at' => '2025-02-13 13:14:09',
      'deleted_at' => null,
    ]);



    // Insert default about content
    DB::table('notification_permissions')->insert([
      'id' => 42,
      'name' => 'update_booking_status',
      'label' => 'Update Booking',
      'title' => 'Booking Update',
      'description' => "Booking ID [[ booking_id ]] has been updated from Pending To Accepted by [[ handyman_name ]].",
      'type' => 'update_booking_status',
      'role_type' => 'Provider',
      'to' => null,
      'bcc' => null,
      'cc' => null,
      'status' => 1,
      'channels' => null,
      'created_by' => null,
      'updated_by' => null,
      'deleted_by' => null,
      'notify_desc' => 'Booking Updated from in Progress to Completed.',
      'created_at' => '2024-04-05 11:39:18',
      'updated_at' => '2025-02-13 13:14:09',
      'deleted_at' => null,
    ]);
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('notification_permissions');
  }
};
