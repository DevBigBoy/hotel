<?php

namespace App\Http\Controllers\Frontend\Booking;

use Carbon\Carbon;
use App\Models\Room;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Symfony\Component\Intl\Countries;
use Illuminate\Support\Facades\Session;

class BookingController extends Controller
{
    public function checkout()
    {
        $countries = Countries::getNames();

        if (Session::has('book_date')) {
            $book_data = Session::get('book_date');
            $room = Room::find($book_data['room_id']);
            $toDate = Carbon::parse($book_data['check_in']);
            $fromDate = Carbon::parse($book_data['check_out']);
            $nights = $toDate->diffInDays($fromDate);
            return view('frontend.pages.checkout.index', compact('book_data', 'room', 'nights', 'countries'));
        } else {
            $notification = array(
                'message' => 'Something want to wrong!',
                'alert-type' => 'error'
            );
            return redirect('/')->with($notification);
        }
    }

    public function BookingStore(Request $request)
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

        dd($request->all());

        if ($request->available_room < $request->number_of_rooms) {

            $notification = array(
                'message' => 'Something want to wrong!',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }


        Session::forget('book_date');

        $data = array();
        $data['number_of_rooms'] = $request->number_of_rooms;
        $data['available_room'] = $request->available_room;
        $data['persion'] = $request->number_of_persons;
        $data['check_in'] = date('Y-m-d', strtotime($request->check_in_date));
        $data['check_out'] = date('Y-m-d', strtotime($request->check_out_date));
        $data['room_id'] = $request->room_id;

        Session::put('book_date', $data);

        return redirect()->route('checkout');
    }
}