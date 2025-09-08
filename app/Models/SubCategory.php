<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
  protected $table = 'sub_categories';
  protected $guard = 'admin';
  protected $fillable = [
    'id',
    'c_name',
    'cat_id',
    'icon',
    'img',
    'type',
    'description',
    'is_features',
    'status',
  ];


    // Define the relationship to the Category model
    public function category()
    {
        return $this->belongsTo(Category::class, 'cat_id');
    }
}
