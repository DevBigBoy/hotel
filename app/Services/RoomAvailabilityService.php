<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\Room;
use App\Models\Booking;
use Carbon\CarbonPeriod;
use InvalidArgumentException;
use App\Models\RoomBookedDate;
use Illuminate\Support\LazyCollection;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;


class RoomAvailabilityService
{
    /**
     * Check room availability based on date range and number of persons.
     *
     * @param string $checkInDate
     * @param string $checkOutDate
     * @param int $numberOfPersons
     * @return EloquentCollection
     * @throws InvalidArgumentException
     */
    public function checkAvailability(string $checkInDate, string $checkOutDate, int $numberOfPersons): LazyCollection
    {
        // Step 1: Parse and adjust check-out date
        $checkInDate = Carbon::parse($checkInDate);
        $checkOutDate = Carbon::parse($checkOutDate)->subDay(); // Inclusive range

        // Step 2: Validate the date range
        // if ($checkInDate->gt($checkOutDate)) {
        //     throw new InvalidArgumentException('Check-in date cannot be after check-out date.');
        // }

        // Step 3: Generate date range array
        $dates = $this->generateDateRange($checkInDate, $checkOutDate);

        dd($dates);
        // Step 4: Get distinct booking IDs for the date range
        $bookingIds = $this->getBookedDates($dates);

        // Step 5: Filter and return available rooms
        return $this->filterRooms($bookingIds, $numberOfPersons);
    }

    /**
     * Generate the date range array in 'Y-m-d' format.
     *
     * @param Carbon $checkInDate
     * @param Carbon $checkOutDate
     * @return array
     */
    protected function generateDateRange(Carbon $checkInDate, Carbon $checkOutDate): array
    {
        $dateRange = CarbonPeriod::create($checkInDate, $checkOutDate);
        // Convert the generator to an array
        return array_map(fn($date) => $date->format('Y-m-d'), iterator_to_array($dateRange));
    }

    /**
     * Get distinct booking IDs for the provided date range.
     *
     * @param array $dates
     * @return array
     */
    protected function getBookedDates(array $dates): array
    {
        return RoomBookedDate::whereIn('book_date', $dates)
            ->distinct()
            ->pluck('booking_id')
            ->toArray();
    }

    /**
     * Filter available rooms based on booking IDs and number of persons.
     *
     * @param array $bookingIds
     * @param int $numberOfPersons
     * @return EloquentCollection
     */
    protected function filterRooms(array $bookingIds, int $numberOfPersons): LazyCollection
    {
        return Room::with(['roomType', 'roomNumbers'])
            ->withCount('roomNumbers')
            ->where('status', 'available')
            ->lazy()
            ->map(function ($room) use ($bookingIds, $numberOfPersons) {
                $totalBookedRooms = $this->getTotalBookedRooms($room->id, $bookingIds);
                $availableRooms = $room->room_numbers_count - $totalBookedRooms;

                // Only return rooms that meet the person's requirement and have availability
                if ($availableRooms > 0 && $numberOfPersons <= $room->total_adults) {
                    $room->available_rooms = $availableRooms;
                    return $room;
                }
                return null;
            })
            ->filter();
    }

    /**
     * Get the total number of booked rooms for a specific room and booking IDs.
     *
     * @param int $roomId
     * @param array $bookingIds
     * @return int
     */
    protected function getTotalBookedRooms(int $roomId, array $bookingIds): int
    {
        return Booking::whereIn('id', $bookingIds)
            ->where('rooms_id', $roomId)
            ->withCount('booking_rooms')
            ->get()
            ->sum('booking_rooms_count');
    }
}