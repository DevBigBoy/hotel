<?php

namespace App\Models;

use App\Models\Room;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RoomNumber extends Model
{
    use HasFactory;
    //'available', 'occupied', 'maintenance'
    protected $fillable = ['room_id', 'room_number', 'status'];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function bookedDates()
    {
        return $this->hasMany(RoomBookedDate::class);
    }

    public function bookingRooms()
    {
        return $this->hasMany(BookingRoom::class, 'room_number_id');
    }

    public function scopeAvailable($query)
    {
        return $query->where('status', 'available');
    }
}