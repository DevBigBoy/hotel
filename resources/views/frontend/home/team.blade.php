<div class="team-area-three pt-100 pb-70">
    <div class="container">
        <div class="section-title text-center">
            <span class="sp-color">TEAM</span>
            <h2>Let's Meet Up With Our Special Team Members</h2>
        </div>
        <div class="team-slider-two owl-carousel owl-theme pt-45">

            @forelse ($teams as $team)
                <div class="team-item">
                    <a href="#">
                        <img src="{{ 'storage/' . $team->image }}" alt="Images">
                    </a>
                    <div class="content">
                        <h3>
                            <a href="team.html">{{ $team->name }}</a>
                        </h3>
                        <span>{{ $team->postion }}</span>
                        <ul class="social-link">
                            <li>
                                <a href="{{ $team->facebook_url }}" target="_blank"><i class='bx bxl-facebook'></i></a>
                            </li>
                            <li>
                                <a href="{{ $team->twitter_url }}" target="_blank"><i class='bx bxl-twitter'></i></a>
                            </li>
                            <li>
                                <a href="{{ $team->instagram_url }}" target="_blank"><i
                                        class='bx bxl-instagram'></i></a>
                            </li>
                            <li>
                                <a href="{{ $team->linkedin_url }}" target="_blank"><i class='bx bxl-linkedin'></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
            @empty
                <div class="team-item">
                    <a href="team.html">
                        <img src="{{ asset('frontend/assets/img/team/team-img2.jpg') }}" alt="Images">
                    </a>
                    <div class="content">
                        <h3><a href="team.html">Carrie Horton</a></h3>
                        <span>Chief Reception Officer</span>
                        <ul class="social-link">
                            <li>
                                <a href="#" target="_blank"><i class='bx bxl-facebook'></i></a>
                            </li>
                            <li>
                                <a href="#" target="_blank"><i class='bx bxl-twitter'></i></a>
                            </li>
                            <li>
                                <a href="#" target="_blank"><i class='bx bxl-instagram'></i></a>
                            </li>
                            <li>
                                <a href="#" target="_blank"><i class='bx bxl-pinterest-alt'></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
            @endforelse



        </div>
    </div>
</div>
