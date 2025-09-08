<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProviderReqModel extends Model
{
  use HasFactory;
  protected $table = 'provider_requests';
  protected $guard = 'admin';
  protected $primaryKey = 'id';

  protected $fillable = [
    'provider_id',
    'amount',
    'status',
    'created_at',
    'bank_id',
    'is_color',
    'is_read',
  ];

  public function vendor()
  {
    return $this->belongsTo(User::class, 'provider_id');
  }

  public function vendorClass()
  {
    return $this->belongsTo(User::class);
  }

  public function bankDetails()
  {
    return $this->hasOne(ProviderBankdetails::class, 'provider_id', 'provider_id');
  }

  public function provider()
  {
    return $this->belongsTo(User::class, 'provider_id');
  }
}
