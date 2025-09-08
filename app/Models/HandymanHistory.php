<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HandymanHistory extends Model
{
  use HasFactory;
  protected $table = 'handyman_history';
  protected $guard = 'admin';
  protected $primaryKey = 'id';

  protected $fillable = [
    'handyman_id',
    'total_bal',
    'available_bal',
    'show_balance',
    'handyman_status',
    'provider_status',
    'created_at',

  ];
}
