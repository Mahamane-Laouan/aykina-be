<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    // use HasFactory, Notifiable;
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'people_id',
        'firstname',
        'lastname',
        'email',
        'mobile',
        'country_code',
        'password',
        'user_role',
        'provider_id',
        'otp',
        'verified_code',
        'login_type',
        'google_id',
        'profile_pic',
        'device_token',
        'is_online',
        'country_flag',
        'main_password',
        // 'dob',
        // 'age',
        'location',
        'country',
        'state',
        'city',
        'wallet_balance',
        'latitude',
        'longitude',
        'refer_code',
        'user_refer_code',
        'mobile_verified_otp',
        'is_blocked',
        'is_read',
        // 'bio',
        // 'interests_id',
        // 'device_token',
        // 'is_Private',
        // 'screen',
        // 'create_date',
        // 'email_verified_at',
        // 'remember_token',
        // 'is_online',
        // 'video_token',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function provider()
    {
        return $this->belongsTo(User::class, 'provider_id', 'id');
    }
}
