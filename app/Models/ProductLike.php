<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductLike extends Model
{
  use HasFactory;
  protected $table = 'product_like';
  protected $guard = 'admin';
  protected $primaryKey = 'id';

  protected $fillable = [
    'product_id',
    'user_id',
    'created_at',

  ];
}
