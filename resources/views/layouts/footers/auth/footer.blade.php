<footer class="footer pt-3  ">
    <div class="container-fluid">
        <div class="row align-items-center justify-content-lg-between">
            <div class="col-lg-6 mb-lg-0 mb-4">
                <div class="copyright text-center text-sm text-muted text-lg-start">
                    ©
                    <script>
                        document.write(new Date().getFullYear())
                    </script>,
                    made with <i class="fa fa-heart"></i> by
                    <a href="{{ route('home') }}" class="font-weight-bold" target="_blank">Hening</a>
                    &
                    <a href="{{ route('home') }}" class="font-weight-bold" target="_blank">Yulia</a>
                    for a better kecak ticketing website.
                </div>
            </div>
            @if(in_array(Auth::user()->role, ['super_admin', 'admin']))
            <div class="col-lg-6">
                <ul class="nav nav-footer justify-content-center justify-content-lg-end">
                    <li class="nav-item">
                        <a href="{{ route('home') }}" class="nav-link text-muted" target="_blank">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('bookings') }}" class="nav-link text-muted" target="_blank">Bookings</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('booking.index') }}" class="nav-link text-muted" target="_blank">Tickets</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('reports') }}" class="nav-link text-muted" target="_blank">Reports</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('profile') }}" class="nav-link pe-0 text-muted"
                            target="_blank">Profile</a>
                    </li>
                </ul>
            </div>
            @endif
        </div>
    </div>
</footer>