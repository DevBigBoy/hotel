<?php

namespace App\Services;

use App\Models\Room;
use Carbon\Carbon;

class RoomService
{
    /**
     * Get all available rooms based on check-in and check-out dates, number of rooms, and total persons.
     *
     * @param string $checkInDate
     * @param string $checkOutDate
     * @param int $numberOfPersons
     * @param int $numberOfRooms
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAvailableRooms($checkInDate, $checkOutDate, $numberOfPersons, $numberOfRooms)
    {
        // Convert input dates to Carbon instances
        $checkInDate = Carbon::parse($checkInDate);
        $checkOutDate = Carbon::parse($checkOutDate);

        // Query to get available rooms that can accommodate the number of persons
        $availableRooms = Room::select([
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
            'status',
        ])
            // Eager load the room type with only necessary columns
            ->with([
                'roomType:id,name', // Only load id and name from roomType
                'roomNumbers' => function ($query) {
                    $query->select(['id', 'room_id', 'room_number', 'status'])
                        ->where('status', 'available');
                }
            ])
            // Efficient count of available room numbers
            ->withCount([
                'roomNumbers as available_room_numbers_count' => function ($query) {
                    $query->where('status', 'available');
                }
            ])
            // Fetch only rooms that are currently available
            ->where('status', 'available')
            // Ensure the room has at least the required number of available rooms
            ->having('available_room_numbers_count', '>=', $numberOfRooms)
            // Ensure room numbers are available and not booked during the date range
            ->whereHas('roomNumbers', function ($query) use ($checkInDate, $checkOutDate) {
                $query->where('status', 'available')
                    // More efficient date exclusion logic: not overlapping the requested range
                    ->whereDoesntHave('bookedDates', function ($subQuery) use ($checkInDate, $checkOutDate) {
                        $subQuery->where(function ($dateQuery) use ($checkInDate, $checkOutDate) {
                            $dateQuery->where('book_date', '<=', $checkOutDate)
                                ->where('book_date', '>=', $checkInDate);
                        });
                    });
            })
            // Use a more performant where condition for capacity
            ->where('capacity', '>=', $numberOfPersons)
            // Optionally, limit the number of results for performance (pagination can be used here)
            ->limit(50)
            ->get();


        return $availableRooms;
    }
}
