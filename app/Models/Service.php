<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $table = 'services';
    protected $primaryKey = 'id';
    protected $guard = 'admin';
    protected $fillable = [
        'id',
        'res_id',
        'cat_id',
        'v_id',
        'service_name',
        'service_price',
        'service_discount_price',
        'service_description',
        'service_image',
        'price_unit',
        'duration',
        'day',
        'start_time',
        'end_time',
        'start_time_period',
        'end_time_period',
        'service_ratings',
        'promo_offer',
        'is_features',
        'status',
        'created_date',
        'lat',
        'lon',
        'slot_book',
        'open_time',
        'close_time',
        'created_at',
        'updated_at',
        'product_id',
        'is_delete',
        'address',
    ];


    public function category()
    {
        return $this->belongsTo(Category::class, 'cat_id');
    }

    // Define the user relationship
    public function vendor()
    {
        return $this->belongsTo(User::class, 'v_id');
    }


    public function serviceImages()
    {
        return $this->hasMany(ServiceImages::class, 'service_id', 'id');
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'service_id', 'id');
    }
}
