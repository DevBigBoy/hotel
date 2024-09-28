<?php

namespace App\Models;

use App\Models\BookingRoom;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'rooms_id',
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

    public function rooms()
    {
        return $this->belongsTo(Room::class, 'rooms_id');
    }

    public function booking_rooms()
    {
        return $this->hasMany(BookingRoom::class, 'booking_id');
    }
}
