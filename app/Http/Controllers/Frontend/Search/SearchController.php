<?php

namespace App\Http\Controllers\Frontend\Search;

use Carbon\Carbon;
use App\Models\Room;
use App\Models\Booking;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use App\Models\RoomBookedDate;
use App\Http\Controllers\Controller;
use App\Services\RoomAvailabilityService;

class SearchController extends Controller
{

    protected $roomAvailabilityService;

    public function __construct(RoomAvailabilityService $roomAvailabilityService)
    {
        $this->roomAvailabilityService = $roomAvailabilityService;
    }

    /**
     * Check room availability.
     */
    public function checkAvailability(Request $request)
    {
        // 1. Validate the request inputs
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
            'number_of_rooms.required' => 'Number of rooms is required.',
            'number_of_rooms.min' => 'Number of rooms must be at least 1.',
        ]);

        try {
            // 2. Call the RoomAvailabilityService to check for available rooms
            $filteredRooms = $this->roomAvailabilityService->checkAvailability(
                $request->check_in_date,
                $request->check_out_date,
                $request->number_of_persons,
                $request->number_of_rooms
            );

            // 3. If no rooms are available, return an error message
            if ($filteredRooms->isEmpty()) {
                return redirect()->route('home')->with([
                    'message' => 'No rooms available for the given criteria.',
                    'alert-type' => 'error'
                ]);
            }

            // 4. Return rooms view with filtered data
            return view('frontend.pages.search.index', [
                'rooms' => $filteredRooms,
                'check_in_date' => $request->check_in_date,
                'check_out_date' => $request->check_out_date,
                'number_of_persons' => $request->number_of_persons,
                'number_of_rooms' => $request->number_of_rooms,
            ]);
        } catch (\Exception $e) {
            return redirect()->route('home')->with([
                'message' => 'Something went wrong. Please try again later.' . $e->getMessage(),
                'alert-type' => 'error'
            ]);
        }
    }

    public function roomDetails(Request $request, string $roomId)
    {
        $request->flash();

        // First, check if the room exists with the required data
        $room = Room::select([
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
            'description',
            'status',
        ])
            // Eager load related data only if necessary
            ->with([
                'roomType:id,name',
                'images:id,image_path,room_id',
                'facilities:id,name',
            ])
            // Count available room numbers
            ->withCount(['roomNumbers as available_room_numbers_count' => function ($query) {
                $query->where('status', 'available');
            }])
            ->where('id', $roomId)
            ->where('status', 'available')
            ->first();

        // If the room is not available, return with an error
        if (!$room || $room->available_room_numbers_count <= 0) {
            $notification = [
                'message' => 'No rooms available',
                'alert-type' => 'error'
            ];
            return redirect()->route('rooms.index')->with($notification);
        }


        // Fetch other rooms excluding the current room and limit to 2
        $other_rooms = Room::select([
            'id',
            'room_type_id',
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
            ->with([
                'roomType:id,name',
            ])
            ->withCount(['roomNumbers as available_room_numbers_count' => function ($query) {
                $query->where('status', 'available');
            }])
            ->where('id', '!=', $room->id)
            ->where('status', 'available')
            ->having('available_room_numbers_count', '>', 0)
            ->orderBy('id', 'DESC')
            ->limit(2)
            ->get();


        return view('frontend.pages.search.show', compact('room', 'other_rooms'));
    }

    public function CheckRoomAvailability(Request $request)
    {
        $request->validate([
            'check_in' => 'required|date|after_or_equal:today',
            'check_out' => 'required|date|after:check_in',
            'room_id' => 'required|exists:rooms,id',
        ]);

        $checkInDate = Carbon::parse($request->check_in)->format('Y-m-d');
        $checkOutDate = Carbon::parse($request->check_out)->format('Y-m-d');

        $room = Room::withCount(['roomNumbers as available_room_numbers_count' => function ($query) {
            $query->where('status', 'available');
        }])->findOrFail($request->room_id);

        if ($room->available_room_numbers_count <= 0) {
            return response()->json([
                'available_room' => 0,
                'total_nights' => 0,
            ]);
        }

        // $bookingIds = RoomBookedDate::whereBetween('book_date', [$checkInDate, $checkOutDate])
        //     ->distinct()
        //     ->pluck('booking_id')
        //     ->toArray();

        // $totalBookedRooms = Booking::whereIn('id', $bookingIds)
        //     ->where('rooms_id', $room->id)
        //     ->sum('number_of_rooms');

        // $availableRooms = $room->available_room_numbers_count - $totalBookedRooms;

        // // Calculate the total nights
        // $totalNights = Carbon::parse($request->check_in)->diffInDays(Carbon::parse($request->check_out));

        // // Return the available rooms and total nights in a JSON response
        // return response()->json([
        //     'available_room' => max($availableRooms, 0),
        //     'total_nights' => $totalNights,
        // ]);

        $bookedRoomNumbers = RoomBookedDate::whereHas('roomNumber', function ($query) use ($room) {
            $query->where('room_id', $room->id);
        })
            ->whereBetween('book_date', [$checkInDate, $checkOutDate])
            ->distinct()
            ->count('room_number_id');

        // 6. Calculate available rooms by subtracting booked rooms
        $availableRooms = $room->available_room_numbers_count - $bookedRoomNumbers;
        $availableRooms = max($availableRooms, 0); // Ensure no negative numbers

        // 7. Calculate the total nights
        $totalNights = Carbon::parse($request->check_in)->diffInDays(Carbon::parse($request->check_out));

        // 8. Return the available rooms and total nights in a JSON response


        return response()->json([
            'available_room' => $availableRooms,
            'total_nights' => $totalNights,
        ]);
    }
}