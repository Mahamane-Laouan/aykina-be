<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingOrders extends Model
{
    use HasFactory;

    protected $table = "booking_orders";
    // protected $primary_key = "id";
    // protected $guard = 'admin';
    protected $fillable = [
        'id',
        'cat_name',
        'payment',
        'location',
        'booking_status',
        'user_id',
        'on_status',
        'payment_method',
        'created_at',
        'service_id',
        'product_id',
        'provider_id',
        'work_assign_id',
        'handyman_status',
        'otp',
        'cart_id',
        'created_at',
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

    // Define the relationship to fetch user addresses
    public function userAddress()
    {
        return $this->belongsTo(UserAddressModel::class, 'location', 'address_id'); // 'location' is the address_id
    }

    public function cartItems()
    {
        return $this->hasMany(CartItemsModel::class, 'order_id', 'id');
    }


    // Relationship with Service model
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
