<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
  protected $table = 'banners';
  protected $guard = 'admin';
  protected $fillable = [
    'id',
    'banners_name',
    'image',
    'cat_id',
  ];

  public function category()
  {
      return $this->belongsTo(Category::class, 'cat_id');
  }
}
