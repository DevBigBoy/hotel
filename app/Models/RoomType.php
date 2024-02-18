<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'status',
    ];

    public function room()
    {
        return $this->hasOne(Room::class, 'room_type_id', 'id');
    }
}