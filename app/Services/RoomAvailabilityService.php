<?php

namespace App\Services;

use App\Models\Room;
use App\Models\RoomNumber;
use Carbon\Carbon;

class RoomAvailabilityService
{
    /**
     * Check room availability based on check-in date, check-out date, number of persons, and number of rooms.
     *
     * @param string $checkInDate
     * @param string $checkOutDate
     * @param int $numberOfPersons
     * @param int $numberOfRooms
     * @return \Illuminate\Support\Collection
     */
    public function checkAvailability($checkInDate, $checkOutDate, $numberOfPersons, $numberOfRooms)
    {
        // Parse the check-in and check-out dates
        $checkInDate = Carbon::parse($checkInDate);
        $checkOutDate = Carbon::parse($checkOutDate);

        // Find available room numbers based on date range and availability
        $availableRoomNumbers = RoomNumber::where('status', 'available')
            ->whereDoesntHave('bookedDates', function ($query) use ($checkInDate, $checkOutDate) {
                $query->whereBetween('book_date', [$checkInDate, $checkOutDate]);
            })
            ->pluck('id'); // Get available room number IDs

        if ($availableRoomNumbers->isEmpty()) {
            return collect();  // Return empty collection if no rooms are available
        }

        // Fetch rooms that have available room numbers and enough capacity
        $rooms = Room::select([
            'id',
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
            'status',
        ])
            ->with(['roomType:id,name', 'roomNumbers' => function ($query) use ($availableRoomNumbers) {
                $query->whereIn('id', $availableRoomNumbers);
            }])
            ->withCount(['roomNumbers' => function ($query) use ($availableRoomNumbers) {
                $query->whereIn('id', $availableRoomNumbers);
            }])
            ->where('status', 'available')
            ->get();

        // Filter rooms based on capacity and number of available rooms
        $filteredRooms = $rooms->filter(function ($room) use ($numberOfPersons, $numberOfRooms) {
            // Room capacity should meet the number of persons requirement
            $roomCapacity = $room->total_adults + $room->total_children;
            $availableRooms = $room->room_numbers_count;

            return $availableRooms >= $numberOfRooms && $numberOfPersons <= $roomCapacity;
        });

        return $filteredRooms;  // Return filtered rooms collection
    }
}