<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceReview extends Model
{
    use HasFactory;

    protected $table = "service_review";
    protected $primary_key = "id";
    protected $guard = 'admin';
    protected $fillable = [
        'id',
        'user_id',
        'service_id',
        'text',
        'star_count',
        'created_at',
        'provider_id',
        'booking_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }


    public function provider()
    {
        return $this->belongsTo(User::class, 'provider_id');
    }
}
