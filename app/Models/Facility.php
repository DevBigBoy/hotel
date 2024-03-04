<?php

namespace App\Models;

use App\Models\Room;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Facility extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug'
    ];

    public function rooms()
    {
        return $this->belongsToMany(
            Room::class,
            'facility_room',
            'facility_id',
            'room_id',
            'id',
            'id'
        );
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($facility) {
            $facility->slug = Str::slug($facility->name);
        });

        static::updating(function ($facility) {
            $facility->slug = Str::slug($facility->name);
        });
    }
}
