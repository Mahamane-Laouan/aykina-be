<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaxRate extends Model
{
  protected $table = 'tax_rates';
  protected $guard = 'admin';
  protected $fillable = [
    'name',
    'zone_id',
    'tax_rate',
    'type',
    'status',
  ];
}
