<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAddressModel extends Model
{
  use HasFactory;
  protected $primaryKey = "address_id";
  protected $table = 'user_addresses';
  protected $fillable = ['user_id', 'full_name', 'phone', 'address', 'address_type', 'landmark', 'city', 'state', 'area_name', 'country', 'zip_code', 'as_default', 'lat', 'lon', 'is_delete'];
}
