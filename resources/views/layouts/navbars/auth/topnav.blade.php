<!-- Navbar -->
<nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl
        {{ str_contains(Request::url(), 'virtual-reality') == true ? ' mt-3 mx-3 bg-primary' : '' }}" id="navbarBlur"
        data-scroll="false">
    <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
        @if (!in_array(request()->route()->getName(), ['user-management', 'profile', 'profile-static']))
                <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                    <li class="breadcrumb-item text-sm"><a class="opacity-5 text-white" href="javascript:;">Pages</a></li>
                    <li class="breadcrumb-item text-sm text-white active" aria-current="page">{{ $title }}</li>
                </ol>
            @else
                <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                    <li class="breadcrumb-item text-sm"><a class="opacity-5 text-white" href="javascript:;">Settings</a></li>
                    <li class="breadcrumb-item text-sm text-white active" aria-current="page">{{ $title }}</li>
                </ol>
            @endif
            <!-- <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                <li class="breadcrumb-item text-sm"><a class="opacity-5 text-white" href="javascript:;">Pages</a></li>
                <li class="breadcrumb-item text-sm text-white active" aria-current="page">{{ $title }}</li>
            </ol> -->
            <h6 class="font-weight-bolder text-white mb-0">{{ $title }}</h6>
        </nav>
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
            <div class="ms-md-auto pe-md-3 d-flex align-items-center">
                <!-- <form class="mb-0">
                <div class="input-group">
                    <span class="input-group-text text-body"><i class="fas fa-search" aria-hidden="true"></i></span>
                    <input type="text" name="search" id="search" class="form-control" placeholder="Type here..." autofocus="true">
                </div>
                </form> -->
                <div class="mb-0">
                <div class="">
                    <span class="d-sm-inline d-none text-white">Hello, {{ auth()->user()->username }}</span>
                </div>
                </div>
            </div>
            <ul class="navbar-nav  justify-content-end">
                <li class="nav-item d-flex align-items-center">
                    <form id="logoutForm" class="mb-0" role="form" method="post" action="{{ route('logout') }}" id="logout-form">
                        @csrf
                        <a href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                            class="nav-link text-white font-weight-bold px-0" data-bs-toggle="modal" data-bs-target="#logoutModal">
                            <i class="fa fa-user me-sm-1"></i>
                            <span class="d-sm-inline d-none">Sign out</span>
                        </a>
                    </form>
                    <!-- Modal -->
                    <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header border-0">
                                    <button type="button" class="btn-close modal1" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body pt-0">
                                    <h5 class="modal-title d-flex justify-content-sm-center text-bolder mb-2 fs-4" id="deleteModalLabel">Confirm Sign Out</h5>
                                    <p class="d-flex justify-content-sm-center mb-0" id="deleteModalLabel">Are you sure you want to sign out?</p>
                                </div>
                                <div class="modal-footer d-flex justify-content-sm-center border-0">
                                    <button type="button" class="btn btn-secondary-alt px-6 border" data-bs-dismiss="modal">No</button>
                                    <button type="button" class="btn btn-secondary px-6" id="confirmLogout">Yes</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
                    <a href="javascript:;" class="nav-link text-white p-0" id="iconNavbarSidenav">
                        <div class="sidenav-toggler-inner">
                            <i class="sidenav-toggler-line bg-white"></i>
                            <i class="sidenav-toggler-line bg-white"></i>
                            <i class="sidenav-toggler-line bg-white"></i>
                        </div>
                    </a>
                </li>
                <!-- setting -->
                <!-- <li class="nav-item pe-2 px-3 d-flex align-items-center">
                    <a class="{{ Route::currentRouteName() == 'profile' ? 'active' : '' }}" href="{{ route('profile') }}" class="nav-link text-white p-0">
                        <i class="fa fa-cog fixed-plugin-button-nav cursor-pointer text-white"></i>
                    </a>
                </li> -->
                <li class="nav-item dropdown pe-2 px-3 d-flex align-items-center">
                    <a href="javascript:;" class="nav-link text-white p-0" id="dropdownMenuButton"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-cog cursor-pointer"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end px-2 py-3 me-sm-n4"
                        aria-labelledby="dropdownMenuButton">
                        <li>
                            <a class="dropdown-item border-radius-md" class="{{ Route::currentRouteName() == 'profile' ? 'active' : '' }}" href="{{ route('profile') }}">
                                <div class="d-flex py-1">
                                    <div class="avatar avatar-sm bg-dark  me-3  my-auto">
                                        <i class="ni ni-single-02 text-info text-sm opacity-10"></i>
                                    </div>
                                    <div class="d-flex flex-column justify-content-center">
                                        <h6 class="text-white text-sm font-weight-bold mb-0">
                                            Profile
                                        </h6>
                                    </div>
                                </div>
                            </a>
                        </li>
                        @if(Auth::user()->role == 'super_admin')
                        <li>
                            <a class="dropdown-item border-radius-md" class="{{ str_contains(request()->url(), 'user-management') == true ? 'active' : '' }}" href="{{ route('user-management') }}">
                                <div class="d-flex py-1">
                                    <div class="avatar avatar-sm bg-dark  me-3  my-auto">
                                        <i class="ni ni-bullet-list-67 text-danger text-sm opacity-10"></i>
                                    </div>
                                    <div class="d-flex flex-column justify-content-center">
                                        <h6 class="text-white text-sm font-weight-bold mb-0">
                                            User Management
                                        </h6>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item border-radius-md" class="{{ Route::currentRouteName() == 'restore.index' ? 'active' : '' }}" href="{{ route('restore.index') }}">
                                <div class="d-flex py-1">
                                    <div class="avatar avatar-sm bg-dark  me-3  my-auto">
                                        <i class="ni ni-folder-17 text-success text-sm opacity-10"></i>
                                    </div>
                                    <div class="d-flex flex-column justify-content-center">
                                        <h6 class="text-white text-sm font-weight-bold mb-0">
                                            Restore
                                        </h6>
                                    </div>
                                </div>
                            </a>
                        </li>
                        @endif
                    </ul>
                </li>
                @if(in_array(Auth::user()->role, ['super_admin', 'admin', 'user']))
                <!-- notif -->
                <li class="nav-item dropdown pe-2 px-2 d-flex align-items-center">
                    <a class="nav-link text-white p-0 {{ str_contains(request()->url(), 'notifications.notif') ? 'active' : '' }}" href="{{ route('notifications.notif') }}">
                        <i class="fa fa-bell cursor-pointer position-relative">
                            @if(isset($hasNewNotifications) && $hasNewNotifications)
                                <span class="notification-badge">{{ $unreadNotificationsCount ?? '' }}</span>
                            @endif
                        </i>
                    </a>
                </li>
                @endif
            </ul>
        </div>
    </div>
<script>
    document.getElementById('confirmLogout').addEventListener('click', function () {
        document.getElementById('logoutForm').submit();
    });
</script>
</nav>
<!-- End Navbar -->

<!-- Include Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Optionally include jQuery if you are using it -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>