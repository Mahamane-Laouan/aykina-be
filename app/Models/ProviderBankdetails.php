<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProviderBankdetails extends Model
{
  use HasFactory;

  protected $table = "provider_bank_details";
  // protected $primary_key = "id";
  // protected $guard = 'admin';
  protected $fillable = [
    'provider_id',
    'bank_name',
    'branch_name',
    'acc_number',
    'ifsc_code',
    'mobile_number',
    'created_at',
    'account_type',
  ];
}
