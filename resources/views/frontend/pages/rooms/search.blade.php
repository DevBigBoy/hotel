@extends('frontend.layouts.master')


@section('content')
    <!-- Inner Banner -->
    <div class="inner-banner inner-bg9">
        <div class="container">
            <div class="inner-title">
                <ul>
                    <li>
                        <a href="{{ route('home') }}">Home</a>
                    </li>
                    <li><i class='bx bx-chevron-right'></i></li>
                    <li>Rooms</li>
                </ul>
                <h3>Rooms</h3>
            </div>
        </div>
    </div>
    <!-- Inner Banner End -->

    <!-- Room Area -->
    <div class="room-area pt-100 pb-70">
        <div class="container">
            <div class="section-title text-center">
                <span class="sp-color">ROOMS</span>
                <h2>Our Rooms & Rates</h2>
            </div>

            <div class="row pt-45">
                @foreach ($rooms as $item)
                    <div>
                        <p>Room ID: {{ $item->id }}</p>
                        <p>Total Room Numbers: {{ $item->room_numbers_count }}</p>
                        <p>Available Rooms: {{ $item->available_rooms ?? 'N/A' }}</p>
                    </div>
                @endforeach

                @foreach ($rooms as $room)
                    <div class="col-lg-4 col-md-6">
                        <div class="room-card">
                            <a href="{{ route('rooms.show', $room->id) }}">
                                <img src="{{ asset('storage/' . $room->image) }}" height="300px" width="100%"
                                    alt="Images">
                            </a>
                            <div class="content">
                                <h3><a href="{{ route('rooms.show', $room->id) }}">{{ $room->roomType->name }} Room</a></h3>
                                <ul>
                                    <li class="text-color">{{ $room->price_per_night }} L.E Per Night</li>
                                    <li class="text-color">{{ $room->room_numbers_count }}</li>
                                </ul>
                                <div class="rating text-color">
                                    <i class='bx bxs-star'></i>
                                    <i class='bx bxs-star'></i>
                                    <i class='bx bxs-star'></i>
                                    <i class='bx bxs-star'></i>
                                    <i class='bx bxs-star-half'></i>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach


            </div>
        </div>
    </div>
    <!-- Room Area End -->
@endsection
