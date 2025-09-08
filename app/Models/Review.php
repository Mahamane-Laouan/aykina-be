<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
  use HasFactory;

  protected $table = "review";
  protected $primary_key = "id";
  protected $guard = 'admin';
  protected $fillable = [
    'id',
    'user_id',
    'text',
    'star_count',
    'cat_id',
    'order_id',
    'send_user_review_id',
    'created_at',
  ];
}
