<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomBookedDate extends Model
{
    use HasFactory;
    protected $fillable = [
        'booking_id', 'room_number_id', 'book_date',
    ];
}