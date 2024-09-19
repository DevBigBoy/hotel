<?php

namespace App\Http\Controllers\Frontend;

use Carbon\Carbon;
use App\Models\Room;
use App\Models\Booking;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use App\Models\RoomBookedDate;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Services\RoomAvailabilityService;

class CheckAvailabilityContorller extends Controller
{

    protected $roomAvailabilityService;

    /**
     * Inject the RoomAvailabilityService into the controller
     *
     * @param RoomAvailabilityService $roomAvailabilityService
     */
    public function __construct(RoomAvailabilityService $roomAvailabilityService)
    {
        $this->roomAvailabilityService = $roomAvailabilityService;
    }

    /**
     * Check room availability based on the request inputs.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function checkAvailability(Request $request)
    {
        $request->validate([
            'check_in_date' => ['required', 'date', 'after_or_equal:today'],
            'check_out_date' => ['required', 'date', 'after:check_in_date'],
            'number_of_persons' => ['required', 'numeric', 'min:1'],
        ], [
            'check_in_date.required' => 'Check-in date is required.',
            'check_in_date.after_or_equal' => 'Check-in date must be today or later.',
            'check_out_date.required' => 'Check-out date is required.',
            'check_out_date.after' => 'Check-out date must be after check-in date.',
            'number_of_persons.required' => 'Number of persons is required.',
            'number_of_persons.min' => 'Number of persons must be at least 1.'
        ]);

        try {
            // Step 2: Use the RoomAvailabilityService to check room availability
            $filteredRooms = $this->roomAvailabilityService->checkAvailability(
                $request->input('check_in_date'),
                $request->input('check_out_date'),
                $request->input('number_of_persons')
            );

            // dd($filteredRooms);
            // Step 3: Return the results to the view
            return response()->json($filteredRooms);
            return view('frontend.pages.rooms.search_results', [
                'rooms' => $filteredRooms,
                'check_in_date' => $request->input('check_in_date'),
                'check_out_date' => $request->input('check_out_date'),
                'number_of_persons' => $request->input('number_of_persons'),
            ]);
        } catch (\Exception $e) {
            $notification = [
                'message' => 'Something went wrong. Please try again later.' . $e->getMessage(),
                'alert-type' => 'Error'
            ];

            // Redirect back with a success message
            return redirect()->back()->with($notification);
        }
    }


    // public function oldcheckAvailability(Request $request)
    // {
    //     $request->validate([
    //         'check_in_date' => ['required', 'date', 'after_or_equal:today'],
    //         'check_out_date' => ['required', 'date', 'after:check_in_date'],
    //         'number_of_persons' => ['required', 'numeric', 'min:1'],
    //     ], [
    //         'check_in_date.required' => 'Check-in date is required.',
    //         'check_in_date.after_or_equal' => 'Check-in date must be today or later.',
    //         'check_out_date.required' => 'Check-out date is required.',
    //         'check_out_date.after' => 'Check-out date must be after check-in date.',
    //         'number_of_persons.required' => 'Number of persons is required.',
    //         'number_of_persons.min' => 'Number of persons must be at least 1.'
    //     ]);

    //     try {
    //         // Parse check-in and check-out dates
    //         $checkInDate = Carbon::parse($request->check_in_date);
    //         $checkOutDate = Carbon::parse($request->check_out_date)->subDay(); // Make the range inclusive

    //         // Validate date range
    //         if ($checkInDate->gt($checkOutDate)) {
    //             abort(400, 'Check-in date cannot be after check-out date.');
    //         }

    //         // Create date period and generate array
    //         $dateRange = CarbonPeriod::create($checkInDate, $checkOutDate)->toArray();
    //         $dates = array_map(fn($date) => $date->format('Y-m-d'), $dateRange);


    //         // Get distinct booking IDs for the given dates

    //         // select distinct * from `room_booked_dates` where `book_date` in (?)

    //         $bookingIds = RoomBookedDate::whereIn('book_date', $dates)
    //             ->distinct()
    //             ->pluck('booking_id')
    //             ->toArray();

    //         // Fetch available rooms with room type and room count
    //         $rooms = Room::with('roomType')
    //             ->withCount('roomNumbers')
    //             ->where('status', 'available')
    //             ->get();


    //         // Filter rooms based on the number of persons
    //         $filteredRooms = $rooms->map(function ($room) use ($request, $bookingIds) {
    //             $bookings = Booking::withCount('booking_rooms')
    //                 ->whereIn('id', $bookingIds)
    //                 ->where('rooms_id', $room->id)
    //                 ->get();

    //             // Calculate total booked rooms
    //             $totalBookedRooms = $bookings->sum('booking_rooms_count');

    //             // Calculate available rooms for the room type
    //             $availableRooms = $room->room_numbers_count - $totalBookedRooms;

    //             // Only return rooms where the number_of_persons is less than or equal to the room capacity
    //             if ($availableRooms > 0 && $request->number_of_persons <= $room->total_adults) {
    //                 $room->available_rooms = $availableRooms;
    //                 return $room;
    //             };
    //         })->filter();

    //         // Return rooms view with filtered data

    //         // Pass filtered rooms and user inputs to the view
    //         return view('frontend.pages.rooms.search_results', [
    //             'rooms' => $filteredRooms,
    //             'check_in_date' => $request->check_in_date,
    //             'check_out_date' => $request->check_out_date,
    //             'number_of_persons' => $request->number_of_persons,
    //         ]);
    //     } catch (\Exception $e) {
    //         // Log error and return custom error message
    //         Log::error('Error checking availability: ' . $e->getMessage());
    //         abort(500, 'Something went wrong. Please try again later.');
    //     }
    // }
}
