<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdersModel extends Model
{
    use HasFactory;
    protected $table = 'orders';
    protected $fillable = [
        'order_id',
        'user_id',
        'total',
        'product_subtotal',
        'service_subtotal',
        'sub_total',
        'coupon',
        'tax',
        'service_charge',
        'shipping_charge',
        'items',
        'payment_mode',
        'address',
        'number',
        'date',
        'datea',
        'txn_id',
        'p_status',
        'p_date',
        'order_status',
        'sales_id',
        'erning_status',
        'order_otp',
        'product_id',
        'service_id',
        'mrp_sub_total',
        'coupon_percentage',
        'coupon_type',
    ];

    // Relationship with Service model
    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }

    // Relationship with User model for user
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relationship with User model for provider
    public function provider()
    {
        return $this->belongsTo(User::class, 'provider_id');
    }


    public function cartItems()
    {
        return $this->hasMany(CartItemsModel::class, 'order_id', 'id');
    }


    // Define the relationship to fetch user addresses
    public function userAddress()
    {
        return $this->belongsTo(UserAddressModel::class, 'location', 'address_id'); // 'location' is the address_id
    }
}
