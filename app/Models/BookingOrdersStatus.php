<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingOrdersStatus extends Model
{
  use HasFactory;

  protected $table = "booking_orders_status";
  // protected $primary_key = "id";
  // protected $guard = 'admin';
  protected $fillable = [
    'booking_id',
    'provider_id',
    'work_assign_id',
    'status',
    'created_at',
    'electricity_on',
    'reason',
  ];
}
