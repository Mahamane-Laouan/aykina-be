<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentGatewayKey extends Model
{
  use HasFactory;
  protected $table = "payment_gateway_key";
  protected $primary_key = "id";
  protected $guard = 'admin';

  protected $fillable = [
    'text',
    'public_key',
    'secret_key',
    'mode',
    'status',
    'country_code',
    'currency_code',

  ];
}
