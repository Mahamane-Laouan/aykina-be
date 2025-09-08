<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AddonProduct extends Model
{
  use HasFactory;
  protected $table = 'addon_product';
  protected $guard = 'admin';
  protected $primaryKey = 'id';

  protected $fillable = [
    'product_id',
    'service_id',
    'vid',

  ];

  public function product()
  {
    return $this->belongsTo(Product::class, 'product_id', 'product_id');
  }
}
