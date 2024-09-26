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
                            <form method="POST" action="" id="bk_form">
                                @csrf

                                <input type="hidden" id="room_id" value="{{ $room->id }}">
                                <input type="hidden" id="capacity" value="{{ $room->capacity }}">
                                <input type="hidden" id="price_per_night" value="{{ $room->price_per_night }}">
                                <input type="hidden" id="discount" value="{{ $room->discount }}">

                                <div class="row align-items-center">
                                    <div class="col-lg-12">

                                        <div class="form-group">
                                            <label>CHECK IN TIME</label>
                                            <div class="input-group">
                                                <input autocomplete="off" id="check_in_date" type="text"
                                                    name="check_in_date" class="form-control dt_picker"
                                                    value="{{ old('check_in_date') ? date('Y-m-d', strtotime(old('check_in_date'))) : 'yyy-mm-dd' }}">
                                                <span class="input-group-addon"></span>
                                            </div>

                                            <i class='bx bxs-calendar'></i>
                                        </div>

                                    </div>

                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label>CHECK OUT TIME</label>
                                            <div class="input-group">
                                                <input autocomplete="off" class="form-control dt_picker" type="text"
                                                    name="check_out_date"
                                                    value="{{ old('check_out_date') ? date('Y-m-d', strtotime(old('check_out_date'))) : 'yyy-mm-dd' }}">
                                                <span class="input-group-addon"></span>
                                            </div>
                                            <i class='bx bxs-calendar'></i>
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label>GUESTS</label>
                                            <select class="form-control" name="number_of_persons">
                                                <option @selected(old('number_of_persons') == '1') value="1">01</option>
                                                <option @selected(old('number_of_persons') == '2') value="2">02</option>
                                                <option @selected(old('number_of_persons') == '3') value="3">03</option>
                                                <option @selected(old('number_of_persons') == '4') value="4">04</option>
                                                <option @selected(old('number_of_persons') == '5') value="5">04</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label>Numbers of Rooms</label>
                                            <select class="form-control number_of_rooms" id="select_room"
                                                name="number_of_rooms">
                                                <option @selected(old('number_of_rooms') == 1) value="1">01</option>
                                                <option @selected(old('number_of_rooms') == 2) value="2">02</option>
                                                <option @selected(old('number_of_rooms') == 3) value="3">03</option>
                                                <option @selected(old('number_of_rooms') == 4) value="4">04</option>
                                                <option @selected(old('number_of_rooms') == 5) value="5">05</option>
                                            </select>
                                        </div>

                                        <input type="hidden" name="available_room" id="available_room">
                                        <p class="available_room"></p>
                                    </div>

                                    <div class="col-lg-12">
                                        <table class="table">

                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <p> SubTotal</p>
                                                    </td>
                                                    <td style="text-align: right"><span class="t_subtotal">0</span> </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <p> Discount</p>
                                                    </td>
                                                    <td style="text-align: right"><span class="t_discount">0</span></td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <p> Total</p>
                                                    </td>
                                                    <td style="text-align: right"><span class="t_g_total">0</span></td>
                                                </tr>

                                            </tbody>
                                        </table>
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
                            <div class="room-details-item">
                                <img src="{{ asset('storage/' . $room->image) }}" width="550" height="400px"
                                    alt="Images">
                            </div>

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
                                            <textarea name="message" class="form-control" cols="30" rows="8" required
                                                data-error="Write your message" placeholder="Write your review here.... "></textarea>
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


@push('scripts')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

    $(document).ready(function(){
    var check_in = {{ old('check_in_date') }};
    var check_in = {{ old('check_in_date') }};
    var check_in = {{ old('check_in_date') }};
    var check_in = {{ old('check_in_date') }};
    })
@endpush
