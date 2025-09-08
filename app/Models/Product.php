<?php

namespace App\Models;

use App\Models\ProductImages;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $guard = 'admin';
    protected $table = 'products';
    protected $primaryKey = "product_id";
    protected $fillable = [
        'product_id',
        'vid',
        'cat_id',
        'product_name',
        'product_description',
        'product_price',
        'product_discount_price',
        'product_image',
        'pro_ratings',
        'status',
        'is_features',
        'product_create_date',
        'created_at',
        'updated_at',
        'is_delete',
    ];


    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id', 'id');
    }

    public function productImages()
    {
        return $this->hasMany(ProductImages::class, 'product_id', 'product_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'cat_id');
    }

    // Define the user relationship
    public function vendor()
    {
        return $this->belongsTo(User::class, 'vid');
    }
}
