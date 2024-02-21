<div class="room-area pt-100 pb-70 section-bg" style="background-color:#ffffff">
    <div class="container">
        <div class="section-title text-center">
            <span class="sp-color">ROOMS</span>
            <h2>Our Rooms & Rates</h2>
        </div>

        <div class="row pt-45">

            @foreach ($rooms as $room)
                <div class="col-lg-6">
                    <div class="room-card-two">
                        <div class="row align-items-center">
                            <div class="col-lg-5 col-md-4 p-0">
                                <div class="room-card-img">
                                    <a href="room-details.html">
                                        <img src="{{ asset('storage/' . $room->image) }}" alt="Images">
                                    </a>
                                </div>
                            </div>

                            <div class="col-lg-7 col-md-8 p-0">
                                <div class="room-card-content">
                                    <h3>
                                        <a href="room-details.html">{{ $room->roomType->name }} Room</a>
                                    </h3>

                                    <span>{{ $room->price_per_night }} L.E / Per Night </span>

                                    <div class="rating">
                                        <i class='bx bxs-star'></i>
                                        <i class='bx bxs-star'></i>
                                        <i class='bx bxs-star'></i>
                                        <i class='bx bxs-star'></i>
                                        <i class='bx bxs-star'></i>
                                    </div>

                                    <p>{{ $room->short_desc }}</p>

                                    <ul>
                                        <li><i class='bx bx-user'></i> {{ $room->capacity }} Person</li>
                                        <li><i class='bx bx-expand'></i>{{ $room->size }}</li>
                                    </ul>

                                    <ul>
                                        <li><i class='bx bx-show-alt'></i> {{ $room->view }} Balcony</li>
                                        <li><i class='bx bxs-hotel'></i> {{ $room->bed_style }}</li>
                                    </ul>

                                    <a href="room-details.html" class="book-more-btn">
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
