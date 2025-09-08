<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
// use Laravel\Sanctum\HasApiTokens;
// use Laravel\Passport\HasApiTokens;

class PeopoleRole extends Authenticatable
{
    use Notifiable;

    protected $primaryKey = 'id';
    protected $table = 'people_role';
    protected $fillable = ['people_role'];
    // protected $guarded = array();
}
