<?php

namespace App\Http\Controllers\Frontend;

use Carbon\Carbon;
use App\Models\Room;
use App\Models\Booking;
use Carbon\CarbonPeriod;
use App\Models\RoomNumber;
use Illuminate\Http\Request;
use App\Models\RoomBookedDate;
use App\Http\Controllers\Controller;

class CheckAvailabilityContorller extends Controller
{
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
            // 2. Parse check-in and check-out dates
            $checkInDate = Carbon::parse($request->check_in_date);
            $checkOutDate = Carbon::parse($request->check_out_date);

            // 3. Find available room numbers based on date range and availability
            $availableRoomNumbers = RoomNumber::where('status', 'available')
                ->whereDoesntHave('bookedDates', function ($query) use ($checkInDate, $checkOutDate) {
                    $query->whereBetween('book_date', [$checkInDate, $checkOutDate]);
                })
                ->pluck('id'); // Get available room number IDs

            if ($availableRoomNumbers->isEmpty()) {
                return redirect()->route('home')->with([
                    'message' => 'No available rooms for the selected dates.',
                    'alert-type' => 'error'
                ]);
            }

            // 4. Fetch rooms that have available room numbers and enough capacity
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

            // 5. Filter rooms based on capacity and number of available rooms
            $filteredRooms = $rooms->filter(function ($room) use ($request) {
                // Room capacity should meet the number of persons requirement
                $roomCapacity = $room->total_adults + $room->total_children;
                $availableRooms = $room->room_numbers_count;

                return $availableRooms >= $request->number_of_rooms &&
                    $request->number_of_persons <= $roomCapacity;
            });

            if ($filteredRooms->isEmpty()) {
                return redirect()->route('home')->with([
                    'message' => 'No rooms available for the given criteria.',
                    'alert-type' => 'error'
                ]);
            }

            // 6. Return rooms view with filtered data
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


    public function BookingSearch(Request $request)
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
            'number_of_rooms.required' => 'Number of persons is required.',
            'number_of_rooms.min' => 'Number of persons must be at least 1.'
        ]);

        try {
            // 2. Parse check-in and check-out dates
            $checkInDate = Carbon::parse($request->check_in_date);
            $checkOutDate = Carbon::parse($request->check_out_date)->subDay(); // Make the range inclusive

            // 3. Create an array of dates between check-in and check-out
            $dateRange = CarbonPeriod::create($checkInDate, $checkOutDate)->toArray();
            $dates = array_map(fn($date) => $date->format('Y-m-d'), $dateRange);

            // 4. Find booking IDs for rooms that overlap with the date range
            $bookingIds = RoomBookedDate::whereIn('book_date', $dates)
                ->distinct()
                ->pluck('booking_id')
                ->toArray();

            // 5. Fetch available rooms with room numbers count
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

            // 6. Fetch bookings and group by rooms_id
            $bookings = Booking::withCount('booking_rooms')
                ->whereIn('id', $bookingIds)
                ->get()
                ->groupBy('rooms_id');

            // 7. Filter rooms based on availability and capacity
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
            return view('frontend.pages.search.index', [
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
            return redirect()->route('home')->with($notification);
        }
    }



    public function anothercheckAvailability(Request $request)
    {
        // Validate the request inputs
        $request->validate([
            'check_in_date' => ['required', 'date', 'after_or_equal:today'],
            'check_out_date' => ['required', 'date', 'after:check_in_date'],
            'number_of_persons' => ['required', 'numeric', 'min:1'],
            'number_of_rooms' => ['required', 'numeric', 'min:1'],
        ], [
            // Custom error messages
            'check_in_date.required' => 'Check-in date is required.',
            'check_in_date.after_or_equal' => 'Check-in date must be today or later.',
            'check_out_date.required' => 'Check-out date is required.',
            'check_out_date.after' => 'Check-out date must be after check-in date.',
            'number_of_persons.required' => 'Number of persons is required.',
            'number_of_persons.min' => 'Number of persons must be at least 1.',
            'number_of_rooms.required' => 'Number of rooms is required.',
            'number_of_rooms.min' => 'Number of rooms must be at least 1.'
        ]);

        try {
            // Parse check-in and check-out dates
            $checkInDate = Carbon::parse($request->check_in_date);
            $checkOutDate = Carbon::parse($request->check_out_date);

            // Create an array of dates between check-in and check-out
            $dateRange = CarbonPeriod::create($checkInDate, $checkOutDate)->toArray();
            $dates = array_map(fn($date) => $date->format('Y-m-d'), $dateRange);

            // Fetch bookings that overlap with the date range directly using SQL joins
            $bookedRoomIds = RoomBookedDate::whereIn('book_date', $dates)
                ->distinct()
                ->pluck('room_number_id')
                ->toArray();

            // Fetch available rooms with related data in a single query
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
                'status'
            ])
                ->with(['roomType:id,name', 'roomNumbers' => function ($query) use ($bookedRoomIds) {
                    // Filter room numbers that are available and not already booked
                    $query->where('status', 'available')
                        ->whereNotIn('id', $bookedRoomIds);
                }])
                ->where('status', 'available')
                ->havingRaw('COUNT(room_numbers.id) >= ?', [$request->number_of_rooms]) // Filter rooms with sufficient availability
                ->get();

            // Filter rooms by capacity and number of persons
            $filteredRooms = $rooms->filter(function ($room) use ($request) {
                return $request->number_of_persons <= $room->capacity;
            });

            // Handle no available rooms
            if ($filteredRooms->isEmpty()) {
                return redirect()->back()->with([
                    'message' => 'No rooms available for the given dates and criteria.',
                    'alert-type' => 'error'
                ]);
            }

            // Return the available rooms view
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
}