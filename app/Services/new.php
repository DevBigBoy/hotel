<?php

namespace App\Services;

use App\Models\RoomType;
use Carbon\Carbon;

class RoomService
{
    /**
     * Main function to get available room types based on check-in date, check-out date, and number of persons.
     *
     * @param string $checkInDate
     * @param string $checkOutDate
     * @param int $numberOfPersons
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAvailableRooms($checkInDate, $checkOutDate, $numberOfPersons)
    {
        // Parse dates
        [$checkInDate, $checkOutDate] = $this->parseDates($checkInDate, $checkOutDate);

        // Fetch available room types
        return RoomType::where('status', 'active') // Only active room types
            ->whereHas('rooms', function ($query) use ($checkInDate, $checkOutDate, $numberOfPersons) {
                $this->applyRoomFilters($query, $checkInDate, $checkOutDate, $numberOfPersons);
            })
            ->with(['rooms.roomNumbers' => function ($query) use ($checkInDate, $checkOutDate) {
                $this->getAvailableRoomNumbers($query, $checkInDate, $checkOutDate);
            }])
            ->get();
    }

    /**
     * Parse and validate the input dates.
     *
     * @param string $checkInDate
     * @param string $checkOutDate
     * @return array
     */
    private function parseDates($checkInDate, $checkOutDate)
    {
        // Parse the input dates into Carbon instances
        $parsedCheckInDate = Carbon::parse($checkInDate);
        $parsedCheckOutDate = Carbon::parse($checkOutDate);

        // Validate date range
        if ($parsedCheckInDate->greaterThanOrEqualTo($parsedCheckOutDate)) {
            throw new \InvalidArgumentException('Check-out date must be after check-in date.');
        }

        return [$parsedCheckInDate, $parsedCheckOutDate];
    }

    /**
     * Apply filters to the rooms query: availability, capacity, and date range.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param \Carbon\Carbon $checkInDate
     * @param \Carbon\Carbon $checkOutDate
     * @param int $numberOfPersons
     * @return void
     */
    private function applyRoomFilters($query, $checkInDate, $checkOutDate, $numberOfPersons)
    {
        $query->where('status', 'available') // Room is marked available
            ->where('capacity', '>=', $numberOfPersons) // Room can accommodate the number of persons
            ->whereHas('roomNumbers', function ($query) use ($checkInDate, $checkOutDate) {
                $this->getAvailableRoomNumbers($query, $checkInDate, $checkOutDate);
            });
    }

    /**
     * Query available room numbers that are not booked in the given date range.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param \Carbon\Carbon $checkInDate
     * @param \Carbon\Carbon $checkOutDate
     * @return void
     */
    private function getAvailableRoomNumbers($query, $checkInDate, $checkOutDate)
    {
        $query->where('status', 'available') // Room number is available
            ->whereDoesntHave('bookedDates', function ($query) use ($checkInDate, $checkOutDate) {
                $this->applyDateRangeFilter($query, $checkInDate, $checkOutDate);
            });
    }

    /**
     * Apply the date range filter to check room availability.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param \Carbon\Carbon $checkInDate
     * @param \Carbon\Carbon $checkOutDate
     * @return void
     */
    private function applyDateRangeFilter($query, $checkInDate, $checkOutDate)
    {
        $query->where(function ($q) use ($checkInDate, $checkOutDate) {
            $q->where('book_date', '<=', $checkOutDate)->where('book_date', '>=', $checkInDate);
        });
    }
}
