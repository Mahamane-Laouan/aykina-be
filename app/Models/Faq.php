<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    use HasFactory;

    protected $table = "faq";
    // protected $primary_key = "id";
    // protected $guard = 'admin';
    protected $fillable = [
        'service_id',
        'cat_id',
        'user_id',
        'title',
        'description',
        'sub_cat_id',
        'created_at',
        'all_service',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }
}
