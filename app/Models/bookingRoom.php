<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingRoom extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'room_number_id',
        'check_in_date',
        'check_out_date'
    ];
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function roomNumber()
    {
        return $this->belongsTo(RoomNumber::class, 'room_number_id');
    }
}