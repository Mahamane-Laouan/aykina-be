<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
  protected $table = 'payment';
  protected $guard = 'admin';
  protected $fillable = [
    'id',
    'res_id',
    'user_id',
    'book_id',
    'transaction_id',
    'payment_mode',
    'payment_status',
    'amount',
    'date',
    'time',
  ];
}
