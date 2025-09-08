<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItemsModel extends Model
{
    use HasFactory;
    protected $table = 'cart_items';
    protected $fillable = ['user_id', 'product_id', 'service_id', 'quantity', 'order_id', 'price', 'coupon_code', 'checked', 'address_id', 'booking_date', 'booking_time', 'notes', 'provider_id', 'addon_service_id', 'coupon_percentage', 'coupon_type'];

    public function provider()
    {
        return $this->belongsTo(User::class, 'provider_id', 'id');
    }

    public function userAddress()
    {
        return $this->belongsTo(UserAddressModel::class, 'address_id', 'address_id');
    }

    // Define the relationship with the Product model
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }

    // Define the relationship with the Service model
    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id', 'id');
    }

    public function bookingOrder()
    {
        return $this->hasOne(BookingOrders::class, 'cart_id', 'cart_id');
    }

    public function productDetails()
    {
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }

    public function serviceDetails()
    {
        return $this->belongsTo(Service::class, 'service_id', 'id');
    }

}
