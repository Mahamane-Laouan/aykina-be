<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingProviderHistory extends Model
{
  use HasFactory;

  protected $table = "booking_provider_history";
  // protected $primary_key = "id";
  // protected $guard = 'admin';
  protected $fillable = [
    'handyman_id',
    'provider_id',
    'booking_id',
    'order_id',
    'created_at',
    'amount',
    'service_id',
    'user_id',
    'commision_persontage',
  ];
}
