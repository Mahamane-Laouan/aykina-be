<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProviderLike extends Model
{
  use HasFactory;
  protected $table = 'provider_like';
  protected $guard = 'admin';
  protected $primaryKey = 'id';

  protected $fillable = [
    'provider_id',
    'user_id',
    'created_at',

  ];
}
