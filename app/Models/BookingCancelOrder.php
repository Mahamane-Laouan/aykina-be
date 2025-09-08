<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingCancelOrder extends Model
{
  use HasFactory;

  protected $table = "handyman_cancel_order";
  protected $primary_key = "id";
  // protected $guard = 'admin';
  protected $fillable = [

    'booking_order_id',
    'handyman_id',
    'handyman_status'
  ];
}
