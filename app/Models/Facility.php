<?php

namespace App\Models;

use App\Models\Room;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Facility extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_id',
        'name',
    ];

    public function rooms()
    {
        return $this->belongsToMany(Room::class, 'facility_room', 'facility_id', 'room_id');
    }
}