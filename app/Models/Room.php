<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $available_rooms
 */

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_type_id',
        'total_adults',
        'total_children',
        'capacity',
        'image',
        'price_per_night',
        'discount',
        'bed_type',
        'view_type',
        'room_size',
        'short_desc',
        'description',
        'status',
    ];

    protected $appends = ['available_rooms'];

    public function roomType()
    {
        return $this->belongsTo(RoomType::class, 'room_type_id', 'id');
    }

    public function roomNumbers()
    {
        return $this->hasMany(RoomNumber::class);
    }

    public function images()
    {
        return $this->hasMany(MultiImage::class, 'room_id', 'id');
    }

    public function facilities()
    {
        return $this->belongsToMany(
            Facility::class,   // related model
            'facility_room',   // pivot Table
            'room_id',         // FK in pivot table for the current model
            'facility_id',     // FK in pivot table for related model
            'id',              // PK for current model
            'id'               // PK for related model
        );
    }

    // Define the accessor for available_rooms
    public function getAvailableRoomsAttribute()
    {
        return $this->attributes['available_rooms'] ?? 0; // Default to 0 if not set
    }

    // You can set this property dynamically like so
    public function setAvailableRooms($value)
    {
        $this->attributes['available_rooms'] = $value;
    }
}
