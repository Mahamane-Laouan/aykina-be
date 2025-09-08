<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AvailablePayment extends Model
{
  protected $table = 'available_payment_mode';
  protected $guard = 'admin';
  protected $fillable = [
    'id',
    'publish_key',
    'secret_key',
    'payment_mode',
    'status',
  ];
}
