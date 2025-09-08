<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceLike extends Model
{
  use HasFactory;
  protected $table = 'service_like';
  protected $guard = 'admin';
  protected $primaryKey = 'id';

  protected $fillable = [
    'service_id',
    'user_id',
    'created_at',

  ];
}
