<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'size',
        'view',
        'bed_style',
        'discount',
        'short_desc',
        'description',
        'status'
    ];


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
}