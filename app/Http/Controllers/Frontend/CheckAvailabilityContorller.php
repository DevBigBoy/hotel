<?php

namespace App\Http\Controllers\Frontend;

use Carbon\Carbon;
use App\Models\Room;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use App\Models\RoomBookedDate;
use App\Http\Controllers\Controller;
use App\Models\Booking;

class CheckAvailabilityContorller extends Controller
{
    public function checkAvailability(Request $request)
    {
        $request->validate([
            'check_in_date' => ['required', 'date', 'after_or_equal:today'],
            'check_out_date' => ['required', 'date', 'after:check_in_date'],
            'number_of_persons' => ['required', 'numeric', 'min:1'],
        ]);



        $checkInDate = Carbon::parse($request->check_in_date);
        $checkOutDate = Carbon::parse($request->check_out_date);

        // Validate date range
        if ($checkInDate->gt($checkOutDate)) {
            abort(400, 'Check-in date cannot be after check-out date.');
        }

        // Create date period
        $checkOutDate = $checkOutDate->subDay(); // Adjust end date to be inclusive
        $d_period = CarbonPeriod::create($checkInDate, $checkOutDate);

        // Generate date array
        $dt_array = array_map(fn($date) => $date->format('Y-m-d'), $d_period->toArray());

        // dd($dt_array);
        $check_date_booking_ids = RoomBookedDate::whereIn('book_date', $dt_array)
            ->distinct()
            ->pluck('booking_id')
            ->toArray();

        $rooms = Room::with('roomType')->withCount('roomNumbers')
            ->where('status', 'available')
            ->get();


        $rooms->each(function ($room) use ($check_date_booking_ids) {
            $bookings = Booking::withCount('booking_rooms')
                ->whereIn('id', $check_date_booking_ids)
                ->where('rooms_id', $room->id)
                ->get();

            $total_booked_rooms = $bookings->sum('booking_rooms_count');

            $room['available_rooms'] = $room->room_numbers_count - $total_booked_rooms;
        });

        return view('frontend.pages.rooms.search', compact('rooms'));
    }
}
