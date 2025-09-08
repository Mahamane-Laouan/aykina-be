<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductReview extends Model
{
  use HasFactory;

  protected $table = "product_review";
  protected $primary_key = "id";
  protected $guard = 'admin';
  protected $fillable = [
    'id',
    'user_id',
    'product_id',
    'booking_id',
    'text',
    'star_count',
    'created_at',
    'provider_id',
  ];
}
