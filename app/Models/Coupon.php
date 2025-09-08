<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
  protected $table = 'coupons';
  protected $guard = 'admin';
  protected $fillable = [
    'id',
    'code',
    'discount',
    'type',
    'status',
    'description',
    'created_at',
    'updated_at',
  ];
}
