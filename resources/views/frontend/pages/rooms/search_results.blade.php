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
                <span class="sp-color">Available Rooms</span>
                <h2>Our Rooms & Rates</h2>
            </div>

            <div>
                <h3>Available Rooms</h3>
                <p><strong>Check-in Date:</strong> {{ $check_in_date }}</p>
                <p><strong>Check-out Date:</strong> {{ $check_out_date }}</p>
                <p><strong>Number of Persons:</strong> {{ $number_of_persons }}</p>
            </div>

            <div class="row pt-45">
                @forelse ($rooms as $room)
                    <div class="col-lg-4 col-md-6">
                        <div class="room-card">
                            <a href="{{ route('rooms.show', $room->id) }}">
                                <img src="{{ asset('storage/' . $room->image) }}" height="300px" width="100%"
                                    alt="Images">
                            </a>

                            <div class="content">
                                <h3>
                                    <a href="{{ route('rooms.show', $room->id) }}">
                                        {{ $room->roomType->name }}
                                        Room
                                    </a>
                                </h3>

                                <p class="card-text">
                                    <strong class="text-color">Room Capacity:</strong> {{ $room->total_adults }} persons<br>
                                    <strong class="text-color">Available Rooms:</strong> {{ $room->available_rooms }}<br>
                                    <strong class="text-color">Price:</strong> ${{ $room->price_per_night }} per night
                                </p>

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
                @empty
            </div>

            <div class="row pt-45">
                <div>
                    <h3>No rooms available for the selected dates and number of persons.</h3>
                </div>
            </div>
            @endforelse

        </div>
    </div>
    <!-- Room Area End -->
@endsection
