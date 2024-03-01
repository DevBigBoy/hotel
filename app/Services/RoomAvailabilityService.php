<?php

namespace App\Services;

use App\Models\Booking;
use Exception;
use Carbon\Carbon;
use App\Models\Room;
use Carbon\CarbonPeriod;
use App\Models\RoomBookedDate;

class RoomAvailabilityService
{
    /**
     * Check room availability for given dates and number of persons.
     *
     * @param  string  $checkInDate
     * @param  string  $checkOutDate
     * @param  int     $numberOfPersons
     * @return array|bool
     */

    public function checkAvailability($checkInDate, $checkOutDate, $numberOfPersons)
    {
        try {
            // Parse check-in and check-out dates
            $checkInDate = Carbon::parse($checkInDate);
            $checkOutDate = Carbon::parse($checkOutDate)->subDay(); // Inclusive range

            // Generate date range array
            $dateRange = CarbonPeriod::create($checkInDate, $checkOutDate)->toArray();
            $dates = array_map(fn($date) => $date->format('Y-m-d'), $dateRange);

            // Get distinct booking IDs for the given dates

            // Get distinct booking IDs for the given dates
            $bookingIds = RoomBookedDate::whereIn('book_date', $dates)
                ->distinct()
                ->pluck('booking_id')
                ->toArray();

            // Fetch available rooms with room type and room count
            $rooms = Room::with('roomType')
                ->withCount('roomNumbers')
                ->where('status', 'available')
                ->get();

            // Filter rooms based on the number of persons

            $filteredRooms = $rooms->map(function ($room) use ($numberOfPersons, $bookingIds) {
                // Get bookings for this room
                $bookings = Booking::whereIn('id', $bookingIds)
                    ->where('rooms_id', $room->id)
                    ->withCount('booking_rooms')
                    ->get();

                // Calculate total booked rooms
                $totalBookedRooms = $bookings->sum('booking_rooms_count');

                // Calculate available rooms for this room type
                $availableRooms = $room->room_numbers_count - $totalBookedRooms;

                // Check if room can accommodate the number of persons
                if ($availableRooms > 0 && $numberOfPersons <= $room->total_adults) {
                    return [
                        'room_id' => $room->id,
                        'room_type' => $room->roomType->name,
                        'available_rooms' => $availableRooms,
                        'capacity' => $room->total_adults,
                    ];
                }

                return null;
            })->filter()->values();

            // Return filtered rooms or false if none available
            return $filteredRooms->isNotEmpty() ? $filteredRooms : false;
        } catch (Exception $th) {
            //throw $th;
        }
    }
}