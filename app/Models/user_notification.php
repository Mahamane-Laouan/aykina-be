<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class user_notification extends Model
{
  use HasFactory;

  protected $fillable = [
    'user_id',
    'handyman_id',
    'title',
    'message',
    'read_status',
    'requests_status',
    'not_type',
    'date',
    'type',
    'booking_id',
    'order_id',
    'provider_id',
    'read_provider',
    'read_handyman',
    'read_user',
    'review_noti',
  ];

  protected $table = "user_notification";

  protected $primary_key = "not_id";
}
