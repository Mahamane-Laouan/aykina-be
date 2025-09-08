<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProviderHistory extends Model
{
  use HasFactory;
  protected $table = 'provider_history';
  protected $guard = 'admin';
  protected $primaryKey = 'id';

  protected $fillable = [
    'provider_id',
    'total_bal',
    'available_bal',
    'created_at',
    'type',

  ];
}
