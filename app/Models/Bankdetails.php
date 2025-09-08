<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bankdetails extends Model
{
  use HasFactory;

  protected $table = "bank_details";
  // protected $primary_key = "id";
  // protected $guard = 'admin';
  protected $fillable = [
    'user_id',
    'provider_id',
    'bank_name',
    'branch_name',
    'acc_number',
    'ifsc_code',
    'mobile_number',
    'created_at',
  ];
}
