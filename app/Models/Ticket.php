<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $table = 'tickets'; // Replace 'table_name' with the name of your database table

    protected $fillable = [
        'user_id',
        'order_id',
        'description',
        'type',
        'image',
        'subject',
        'created_at',
        'updated_at',
        // Add more columns as needed
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


    public function supportChatStatus()
    {
        return $this->hasOne(SupportChatstatus::class, 'order_number', 'order_id');
    }
}
