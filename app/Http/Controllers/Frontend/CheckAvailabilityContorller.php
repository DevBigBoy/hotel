<?php

namespace App\Http\Controllers\Frontend;

use Carbon\Carbon;
use App\Models\Room;
use App\Models\Booking;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use App\Services\RoomService;
use App\Models\RoomBookedDate;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class CheckAvailabilityContorller extends Controller
{
    public function checkAvailability(Request $request)
    {
        $request->validate([
            'check_in_date' => ['required', 'date', 'after_or_equal:today'],
            'check_out_date' => ['required', 'date', 'after:check_in_date'],
            'number_of_persons' => ['required', 'numeric', 'min:1'],
            'number_of_rooms' => ['required', 'numeric', 'min:1'],
        ], [
            'check_in_date.required' => 'Check-in date is required.',
            'check_in_date.after_or_equal' => 'Check-in date must be today or later.',
            'check_out_date.required' => 'Check-out date is required.',
            'check_out_date.after' => 'Check-out date must be after check-in date.',
            'number_of_persons.required' => 'Number of persons is required.',
            'number_of_persons.min' => 'Number of persons must be at least 1.',
            'number_of_rooms.required' => 'Number of persons is required.',
            'number_of_rooms.min' => 'Number of persons must be at least 1.'
        ]);

        try {
            // Parse check-in and check-out dates
            $checkInDate = Carbon::parse($request->check_in_date);
            $checkOutDate = Carbon::parse($request->check_out_date)->subDay(); // Make the range inclusive

            // Create date period and generate array
            $dateRange = CarbonPeriod::create($checkInDate, $checkOutDate)->toArray();
            $dates = array_map(fn($date) => $date->format('Y-m-d'), $dateRange);

            // Get distinct booking IDs that overlap with the date range
            $bookingIds = RoomBookedDate::whereIn('book_date', $dates)
                ->distinct()
                ->pluck('booking_id')
                ->toArray();

            // Step 2: Fetch rooms along with their room numbers and room type
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
                ->with('roomType:id,name')
                ->withCount([
                    'roomNumbers'
                    => function ($query) {
                        $query->where('status', 'available');
                    }
                ])
                ->where('status', 'available')
                ->get();

            // Step 3: Fetch bookings with room and booking_rooms count
            $bookings = Booking::withCount('booking_rooms')
                ->whereIn('id', $bookingIds)
                ->get()
                ->groupBy('rooms_id');

            // Step 4: Filter rooms based on availability and the number of persons
            $filteredRooms = $rooms->map(function ($room) use ($request, $bookings) {
                // Fetch all bookings for the current room
                $roomBookings = $bookings->get($room->id, collect());

                // Calculate the total number of rooms booked for this room type
                $totalBookedRooms = $roomBookings->sum('booking_rooms_count');

                // Calculate the available rooms
                $availableRooms = $room->room_numbers_count - $totalBookedRooms;

                // Filter based on the number of persons and available rooms
                if (
                    $availableRooms >= $request->number_of_rooms &&
                    $request->number_of_persons <= $room->capacity
                ) {
                    $room->available_rooms = $availableRooms;
                    return $room; // Return the room if it matches the criteria
                }

                return null;
            })->filter();

            // return response()->json($filteredRooms->isEmpty());

            if ($filteredRooms->isEmpty()) {
                $notification = [
                    'message' => 'No rooms available for the given dates and criteria.',
                    'alert-type' => 'error'
                ];

                // Redirect back with a success message
                return redirect()->back()->with($notification);
            }

            // Return rooms view with filtered data
            return view('frontend.pages.rooms.search_results', [
                'rooms' => $filteredRooms,
                'check_in_date' => $request->check_in_date,
                'check_out_date' => $request->check_out_date,
                'number_of_persons' => $request->number_of_persons,
                'number_of_rooms' => $request->number_of_rooms,
            ]);
        } catch (\Exception $e) {

            $notification = [
                'message' => 'Something went wrong. Please try again later.' . $e->getMessage(),
                'alert-type' => 'error'
            ];

            // Redirect back with a success message
            return redirect()->back()->with($notification);
        }
    }
}



// function oldcheckAvailability(Request $request)
// {

//     $request->validate([
//         'check_in_date' => 'required|date|after_or_equal:today',  // Must be a valid date not in the past
//         'check_out_date' => 'required|date|after:check_in_date',  // Must be a valid date after check-in date
//         'number_of_persons' => 'required|numeric|min:1',  // Must be a positive integer
//         'number_of_rooms' => 'required|numeric|min:1',    // Must b
//     ], [
//         'check_in_date.required' => 'Check-in date is required.',
//         'check_in_date.after_or_equal' => 'Check-in date must be today or later.',
//         'check_out_date.required' => 'Check-out date is required.',
//         'check_out_date.after' => 'Check-out date must be after check-in date.',
//         'number_of_persons.required' => 'Number of persons is required.',
//         'number_of_persons.min' => 'Number of persons must be at least 1.',
//         'number_of_rooms.required' => 'Number of Rooms is required.',
//         'number_of_rooms.min' => 'Number of Rooms must be at least 1.'
//     ]);

//     $checkInDate = $request->input('check_in_date');
//     $checkOutDate = $request->input('check_out_date');
//     $numberOfPersons = $request->input('number_of_persons');
//     $numberOfRooms = $request->input('number_of_rooms');

//     // Use the RoomService to get available rooms
//     $availableRooms = $this->roomService->getAvailableRooms(
//         $checkInDate,
//         $checkOutDate,
//         $numberOfPersons,
//         $numberOfRooms,
//     );

//     if ($availableRooms->isEmpty()) {
//         return response()->json(['message' => 'No rooms available for the given dates and criteria.'], 404);
//     }

//     return response()->json($availableRooms, 200);
// }
