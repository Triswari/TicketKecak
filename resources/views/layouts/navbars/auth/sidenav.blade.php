<aside class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4"
    id="sidenav-main">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
            aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand m-0" href="{{ route('home') }}" target="_blank">
            <img src="/img/kecak_barong_nusa_dua_logo.png" class="navbar-brand-img h-100" alt="main_logo">
            <span class="ms-1 font-weight-bold">Bali Langen The Nusa Dua</span>
        </a>
    </div>
    <hr class="horizontal dark mt-0">
    <div class="collapse navbar-collapse w-auto" id="sidenav-collapse-main">
        <ul class="navbar-nav">
        
            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteName() == 'home' ? 'active' : '' }}" href="{{ route('home') }}">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-tv-2 text-primary text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Dashboard</span>
                </a>
            </li>
            <li class="nav-item mt-3 d-flex align-items-center">
                <div class="ps-4">
                    <i class="ni ni-single-copy-04 text-dark"></i>
                </div>
                <h6 class="ms-2 text-uppercase text-xs font-weight-bolder mb-0">Pages</h6>
            </li>
            @if(in_array(Auth::user()->role, ['super_admin', 'admin']))
            <li class="nav-item">
                <a class="nav-link {{ str_contains(request()->url(), 'bookings') == true ? 'active' : '' }}" href="{{ route('bookings') }}">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-calendar-grid-58 text-warning text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Bookings</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{  str_contains(request()->url(), 'tickets') == true ? 'active' : '' }}" href="{{ route('booking.index') }}">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fas fa-ticket-alt text-success text-sm opacity-10 mb-1"></i>
                    </div>
                    <span class="nav-link-text ms-1">Tickets</span>
                </a>
            </li>
            @endif
            <li class="nav-item">
                <a class="nav-link {{  str_contains(request()->url(), 'reports') == true ? 'active' : '' }}" href="{{ route('reports') }}">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-chart-pie-35 text-info text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Reports</span>
                </a>
            </li>
            @if(in_array(Auth::user()->role, ['super_admin', 'admin']))
            <li class="nav-item">
                <a class="nav-link {{  str_contains(request()->url(), 'products') == true ? 'active' : '' }}" href="{{ route('products.index') }}">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fas fa-box text-danger text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Products</span>
                </a>
            </li>
            @endif
            <li class="nav-item mt-3 d-flex align-items-center">
                <div class="ps-4">
                    <i class="fas fa-cog" style="color: #344767;"></i>
                </div>
                <h6 class="ms-2 text-uppercase text-xs font-weight-bolder mb-0">Settings</h6>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteName() == 'profile' ? 'active' : '' }}" href="{{ route('profile') }}">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-single-02 text-info text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Profile</span>
                </a>
            </li>
            @if(Auth::user()->role == 'super_admin')
            <li class="nav-item">
                <a class="nav-link {{ str_contains(request()->url(), 'user-management') ? 'active' : '' }}" href="{{ route('user-management') }}">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-bullet-list-67 text-danger text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">User Management</span>
                    @if(isset($unreadAdminRequestsCount) && $unreadAdminRequestsCount > 0)
                        <span class="badge bg-danger ms-2">{{ $unreadAdminRequestsCount }}</span>
                    @endif
                </a>
            </li>
            @endif
        </ul>
    </div>
    <div class="sidenav-footer mx-3">
        <div class="card card-plain shadow-none p-3" id="sidenavCard">
            <hr class="horizontal dark my-sm-4">
            <div class="mt-2 mb-5 d-flex">
                <h6 class="mb-0">Light / Dark</h6>
                <div class="form-check form-switch ps-0 ms-auto my-auto">
                    <input class="form-check-input mt-1 ms-auto" type="checkbox" id="dark-version" onclick="darkMode(this)">
                </div>
            </div>
        </div>
    </div>     
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const body = document.body;
        const sidenav = document.getElementById('sidenav-main');
        const darkModeToggle = document.getElementById('dark-version');

        // Periksa status dark mode di localStorage
        if (localStorage.getItem('dark-version') === 'enabled') {
            enableDarkMode();
        } else {
            disableDarkMode();
        }

        // Tambahkan event listener untuk toggle button
        darkModeToggle.addEventListener('click', function() {
            if (localStorage.getItem('dark-version') !== 'enabled') {
                enableDarkMode();
            } else {
                disableDarkMode();
            }
        });

        function enableDarkMode() {
            body.classList.add('dark-version');
            body.classList.remove('bg-white');
            sidenav.classList.add('dark-version');
            sidenav.classList.remove('bg-white');
            localStorage.setItem('dark-version', 'enabled');
        }

        function disableDarkMode() {
            body.classList.remove('dark-version');
            body.classList.add('bg-white');
            sidenav.classList.remove('dark-version');
            sidenav.classList.add('bg-white');
            localStorage.setItem('dark-version', 'disabled');
        }
    });
</script>

</aside>
