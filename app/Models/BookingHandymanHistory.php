<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingHandymanHistory extends Model
{
    use HasFactory;

    protected $table = "booking_handyman_history";
    // protected $primary_key = "id";
    // protected $guard = 'admin';
    protected $fillable = [
        'handyman_id',
        'provider_id',
        'booking_id',
        'handman_status',
        'created_at',
        'provider_status',
        'amount',
        'service_id',
        'user_id',
        'commision_persontage',
    ];


    // Define the relationship to the Handyman model
    public function handyman()
    {
        return $this->belongsTo(User::class, 'handyman_id', 'id');
    }

    // Define the relationship to the Provider model
    public function provider()
    {
        return $this->belongsTo(User::class, 'provider_id', 'id');
    }

    // Define the service relationship
    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id'); // Adjust 'service_id' as per your database column name
    }
}
