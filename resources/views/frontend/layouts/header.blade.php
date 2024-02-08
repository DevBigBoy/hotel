<header class="top-header top-header-bg">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-3 col-md-2 pr-0">
                <div class="language-list">
                    <select class="language-list-item">
                        <option>English</option>
                        <option>العربيّة</option>
                    </select>
                </div>
            </div>

            <div class="col-lg-9 col-md-10">
                <div class="header-right">
                    <ul>

                        @if (Route::has('login'))
                            @auth
                                <li>
                                    <i class='bx bxs-dashboard bx-tada-hover'></i> <a
                                        href="{{ Auth::user()->role === 'admin' ? route('admin.dashboard') : route('dashboard') }}">Dashboard</a>
                                </li>
                            @else
                                <li>
                                    <i class='bx bx-user bx-tada-hover'></i>
                                    <a href="{{ route('login') }}">Login</a>
                                </li>

                                @if (Route::has('register'))
                                    <li>
                                        <i class='bx bx-user-plus bx-tada-hover'></i>
                                        <a href="{{ route('register') }}">
                                            Register
                                        </a>

                                    </li>
                                @endif
                            @endauth
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
</header>
