<?php

namespace App\Http\Controllers\Frontend\Room;

use Carbon\Carbon;
use App\Models\Room;
use App\Models\Booking;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use App\Models\RoomBookedDate;
use App\Http\Controllers\Controller;

class RoomsController extends Controller
{
    public function index()
    {
        $rooms = Room::select([
            'id',
            'room_type_id',
            'image',
            'price_per_night',
            'status',
        ])
            ->with([
                'roomType:id,name',
            ])
            ->withCount(['roomNumbers as available_room_numbers_count' => function ($query) {
                $query->where('status', 'available');
            }])
            ->where('status', 'available')
            ->having('available_room_numbers_count', '>', 0)
            ->get();

        // return response()->json($rooms);

        return view('frontend.pages.rooms.index', [
            'rooms' => $rooms
        ]);
    }

    public function show(Request $request, string $roomId)
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
                'images:id,image_path,room_id', // Include room_id in images for relationship
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
            return redirect()->back()->with($notification);
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

        // return response()->json($room);
        // Return the view with the room and other available rooms
        return view('frontend.pages.rooms.show', compact('room', 'other_rooms'));
    }


    public function CheckRoomAvailability(Request $request)
    {
        $request->validate([
            'check_in' => 'required|date|after_or_equal:today',
            'check_out' => 'required|date|after:check_in',
            'room_id' => 'required|exists:rooms,id',
        ]);

        $checkInDate = Carbon::parse($request->check_in)->format('Y-m-d');
        $checkOutDate = Carbon::parse($request->check_out)->subDay()->format('Y-m-d');

        $room = Room::withCount(['roomNumbers as available_room_numbers_count' => function ($query) {
            $query->where('status', 'available');
        }])->findOrFail($request->room_id);

        if ($room->available_room_numbers_count <= 0) {
            return response()->json([
                'available_room' => 0,
                'total_nights' => 0,
            ]);
        }

        $bookingIds = RoomBookedDate::whereBetween('book_date', [$checkInDate, $checkOutDate])
            ->distinct()
            ->pluck('booking_id')
            ->toArray();

        $totalBookedRooms = Booking::whereIn('id', $bookingIds)
            ->where('rooms_id', $room->id)
            ->sum('number_of_rooms');

        $availableRooms = $room->available_room_numbers_count - $totalBookedRooms;

        // Calculate the total nights
        $totalNights = Carbon::parse($request->check_in)->diffInDays(Carbon::parse($request->check_out));

        // Return the available rooms and total nights in a JSON response
        return response()->json([
            'available_room' => max($availableRooms, 0),
            'total_nights' => $totalNights,
        ]);
    }

    public function oldCheckRoomAvailability(Request $request)
    {
        $sdate = date('Y-m-d', strtotime($request->check_in));
        $edate = date('Y-m-d', strtotime($request->check_out));
        $alldate = Carbon::create($edate)->subDay();
        $d_period = CarbonPeriod::create($sdate, $alldate);
        $dt_array = [];
        foreach ($d_period as $period) {
            array_push($dt_array, date('Y-m-d', strtotime($period)));
        }

        $check_date_booking_ids = RoomBookedDate::whereIn('book_date', $dt_array)->distinct()->pluck('booking_id')->toArray();

        $room = Room::withCount('room_numbers')->find($request->room_id);

        $bookings = Booking::withCount('assign_rooms')->whereIn('id', $check_date_booking_ids)->where('rooms_id', $room->id)->get()->toArray();

        $total_book_room = array_sum(array_column($bookings, 'assign_rooms_count'));
        $av_room = @$room->room_numbers_count - $total_book_room;
        $toDate = Carbon::parse($request->check_in);
        $fromDate = Carbon::parse($request->check_out);
        $nights = $toDate->diffInDays($fromDate);
        return response()->json(['available_room' => $av_room, 'total_nights' => $nights]);
    }
}
