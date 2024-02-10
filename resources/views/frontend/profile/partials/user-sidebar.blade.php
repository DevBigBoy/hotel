<div class="service-side-bar">
    <div class="services-bar-widget">
        <h3 class="title">User Sidebar</h3>
        <div class="side-bar-categories">
            <img src="{{ asset(Auth::user()->photo) }}" class="rounded mx-auto d-block" alt="Image"
                style="width: 130px; height: 130px" />

            @auth
                <div class="my-3 text-center">
                    <h5>{{ Auth::user()->name }}</h5>
                    <p class="text-muted font-size-sm">{{ Auth::user()->email }}</p>
                </div>
            @endauth

            <ul>
                <li class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <a href="{{ route('dashboard') }} ">User Dashboard</a>
                </li>

                <li class="{{ request()->routeIs('profile.edit') ? 'active' : '' }}">
                    <a href="{{ route('profile.edit') }}">User Profile </a>
                </li>

                <li class="{{ request()->routeIs('profile.booking') ? 'active' : '' }}">
                    <a href="{{ route('profile.booking') }}">Booking Details </a>
                </li>

                <li class="{{ request()->routeIs('profile.password') ? 'active' : '' }}">
                    <a href="{{ route('profile.password') }}">Change Password</a>
                </li>


                <li>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <a href="{{ route('logout') }}"
                            onclick="event.preventDefault(); this.closest('form').submit();">
                            <i class="bx bx-log-out-circle"></i><span>Logout</span>
                        </a>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</div>
