<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_id',
        'user_id',
        'check_in',
        'check_out',
        'amount_paid',
        'payment_method',
        'payment_status',
        'transaction_id',
        'total_night',
        'actual_price',
        'subtotal',
        'discount',
        'total_price',
        'person',
        'status'
    ];
}