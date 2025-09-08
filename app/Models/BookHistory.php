<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookHistory extends Model
{
  protected $table = 'booking_orders';
  protected $guard = 'admin';
  protected $fillable = [
    'id',
    'cat_name',
    'payment',
    'location',
    'booking_status',
    'user_id',
    'work_assign_id',
    'on_status',
    'provider_id',
    'payment_method',
    'service_id',
    'product_id',
    'handyman_status',
    'otp',
    'order_id',
    'payment_status ',
    'created_at',
    'updated_at',
  ];
}
