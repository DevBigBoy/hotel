@extends('frontend.layouts.master')


@section('content')
    <!-- Inner Banner -->
    <div class="inner-banner inner-bg10">
        <div class="container">
            <div class="inner-title">
                <ul>
                    <li>
                        <a href="{{ route('home') }}">Home</a>
                    </li>
                    <li><i class='bx bx-chevron-right'></i></li>
                    <li>Room Details </li>
                </ul>
                <h3>{{ $room->roomType->name }}</h3>
            </div>
        </div>
    </div>
    <!-- Inner Banner End -->

    <!-- Room Details Area End -->
    <div class="room-details-area pt-100 pb-70">
        <div class="container">
            <div class="row">
                <div class="col-lg-4">
                    <div class="room-details-side">
                        <div class="side-bar-form">
                            <h3>Booking Sheet </h3>
                            <form>
                                <div class="row align-items-center">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label>Check in</label>
                                            <div class="input-group">
                                                <input id="datetimepicker" type="text" class="form-control"
                                                    placeholder="09/29/2020">
                                                <span class="input-group-addon"></span>
                                            </div>
                                            <i class='bx bxs-calendar'></i>
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label>Check Out</label>
                                            <div class="input-group">
                                                <input id="datetimepicker-check" type="text" class="form-control"
                                                    placeholder="09/29/2020">
                                                <span class="input-group-addon"></span>
                                            </div>
                                            <i class='bx bxs-calendar'></i>
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label>Numbers of Persons</label>
                                            <select class="form-control">
                                                <option>01</option>
                                                <option>02</option>
                                                <option>03</option>
                                                <option>04</option>
                                                <option>05</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label>Numbers of Rooms</label>
                                            <select class="form-control">
                                                <option>01</option>
                                                <option>02</option>
                                                <option>03</option>
                                                <option>04</option>
                                                <option>05</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-12 col-md-12">
                                        <button type="submit" class="default-btn btn-bg-three border-radius-5">
                                            Book Now
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-lg-8">
                    <div class="room-details-article">
                        <div class="room-details-slider owl-carousel owl-theme">
                            @forelse ($room->images as $image)
                                <div class="room-details-item">
                                    <img src="{{ asset('storage/' . $image->image_path) }}" alt="Images" width="550px"
                                        height="400px">
                                </div>
                            @empty
                                <div class="room-details-item">
                                    <img src="{{ asset('storage/' . $room->image) }}" width="550" height="400px"
                                        alt="Images">
                                </div>
                            @endforelse
                        </div>

                        <div class="room-details-title">
                            <h2 style="max-width: 100%">{{ $room->roomType->name }}</h2>
                            <ul>
                                <li>
                                    <b> Basic : {{ $room->price_per_night }}L.E /Night/Room</b>
                                </li>
                            </ul>
                        </div>

                        <div class="room-details-content">

                            {!! $room->description !!}

                            <div class="side-bar-plan">
                                <h3>Basic Plan Facilities</h3>
                                <ul>
                                    @foreach ($room->facilities as $facility)
                                        <li><a href="#">{{ $facility->name }}</a></li>
                                    @endforeach
                                </ul>
                            </div>

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="services-bar-widget">
                                        <h3 class="title">Download Brochures</h3>
                                        <div class="side-bar-list">
                                            <ul>
                                                <li>
                                                    <a href="#">
                                                        <b>Capacity : </b> {{ $room->capacity }} Person
                                                        <i class='bx bxs-cloud-download'></i>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#">
                                                        <b>Size : </b> {{ $room->size }} m2 / 276ft2
                                                        <i class='bx bxs-cloud-download'></i>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>

                                </div>



                                <div class="col-lg-6">
                                    <div class="services-bar-widget">
                                        <h3 class="title">Download Brochures</h3>
                                        <div class="side-bar-list">
                                            <ul>
                                                <li>
                                                    <a href="#">
                                                        <b>View : </b> {{ $room->view }}
                                                        <i class='bx bxs-cloud-download'></i>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#">
                                                        <b>Bad Style : </b> {{ $room->bed_style }}
                                                        <i class='bx bxs-cloud-download'>
                                                        </i>
                                                    </a>
                                                </li>

                                            </ul>
                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>

                        <div class="room-details-review">
                            <h2>Clients Review and Retting's</h2>
                            <div class="review-ratting">
                                <h3>Your retting: </h3>
                                <i class='bx bx-star'></i>
                                <i class='bx bx-star'></i>
                                <i class='bx bx-star'></i>
                                <i class='bx bx-star'></i>
                                <i class='bx bx-star'></i>
                            </div>
                            <form>
                                <div class="row">
                                    <div class="col-lg-12 col-md-12">
                                        <div class="form-group">
                                            <textarea name="message" class="form-control" cols="30" rows="8" required data-error="Write your message"
                                                placeholder="Write your review here.... "></textarea>
                                        </div>
                                    </div>

                                    <div class="col-lg-12 col-md-12">
                                        <button type="submit" class="default-btn btn-bg-three">
                                            Submit Review
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Room Details Area End -->

    <!-- Room Details Other -->
    <div class="room-details-other pb-70">
        <div class="container">
            <div class="room-details-text">
                <h2>Our Related Offer</h2>
            </div>

            <div class="row ">
                @foreach ($other_rooms as $room)
                    <div class="col-lg-6">
                        <div class="room-card-two">
                            <div class="row align-items-center">
                                <div class="col-lg-5 col-md-4 p-0">
                                    <div class="room-card-img">
                                        <a href="{{ route('rooms.show', $room->id) }}">
                                            <img src="{{ asset('storage/' . $room->image) }}" alt="Images">
                                        </a>
                                    </div>
                                </div>

                                <div class="col-lg-7 col-md-8 p-0">
                                    <div class="room-card-content">
                                        <h3>
                                            <a href="{{ route('rooms.show', $room->id) }}">{{ $room->roomType->name }}
                                                Room</a>
                                        </h3>
                                        <span>{{ $room->price_per_night }} / Per Night </span>
                                        <div class="rating">
                                            <i class="bx bxs-star"></i>
                                            <i class="bx bxs-star"></i>
                                            <i class="bx bxs-star"></i>
                                            <i class="bx bxs-star"></i>
                                            <i class="bx bxs-star"></i>
                                        </div>
                                        <p>
                                            {!! Str::limit($room->short_desc, 150) !!}
                                        </p>
                                        <ul>
                                            <li><i class="bx bx-user"></i> 4 Person</li>
                                            <li><i class="bx bx-expand"></i> 35m2 / 376ft2</li>
                                        </ul>

                                        <ul>
                                            <li><i class="bx bx-show-alt"></i> Sea Balcony</li>
                                            <li><i class="bx bxs-hotel"></i> Kingsize / Twin</li>
                                        </ul>

                                        <a href="{{ route('rooms.show', $room->id) }}" class="book-more-btn">
                                            Book Now
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <!-- Room Details Other -->
@endsection
