@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'User Profile'])
    <div class="card shadow-lg mx-4">
        <div class="card-body p-3">
            <div class="row gx-4">
                <div class="col-auto">
                    <div class="avatar avatar-xl position-relative">
                        <img src="/img/team-1.jpg" alt="profile_image" class="w-100 border-radius-lg shadow-sm">
                    </div>
                </div>
                <div class="col-auto my-auto">
                    <div class="h-100">
                        <h5 class="mb-1">
                            {{ $user->firstname ?? 'Firstname' }} {{ $user->lastname ?? 'Lastname' }}
                        </h5>
                        <p class="mb-0 font-weight-bold text-sm">
                            @php
                                $role = $user->role ?? 'Role';
                                switch ($role) {
                                    case 'user':
                                        $roleName = 'User';
                                        break;
                                    case 'admin':
                                        $roleName = 'Admin';
                                        break;
                                    case 'super_admin':
                                        $roleName = 'Expert';
                                        break;
                                    default:
                                        $roleName = $role;
                                }
                            @endphp
                            {{ $roleName }}
                        </p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 my-sm-auto ms-sm-auto me-sm-0 mx-auto mt-3">
                    <div class="nav-wrapper position-relative end-0">
                        <ul class="nav nav-pills nav-fill p-1">
                            <li class="nav-item">
                                <form method="POST" action="{{ route('updateRole', ['id' => $user->id]) }}">
                                    @csrf
                                    <button type="submit" name="role" value="user" class="nav-link role-profile mb-0 px-0 py-1 d-flex align-items-center justify-content-center {{ $user->role == 'user' ? 'active' : '' }}">
                                        <i class="fas fa-user"></i>
                                        <span class="ms-2">User</span>
                                    </button>
                                </form>
                            </li>
                            <li class="nav-item">
                                <form method="POST" action="{{ route('updateRole', ['id' => $user->id]) }}">
                                    @csrf
                                    <button type="submit" name="role" value="admin" class="nav-link role-profile mb-0 px-0 py-1 d-flex align-items-center justify-content-center {{ $user->role == 'admin' ? 'active' : '' }}">
                                        <i class="fas fa-user-tie"></i>
                                        <span class="ms-2">Admin</span>
                                    </button>
                                </form>
                            </li>
                            <li class="nav-item">
                                <form method="POST" action="{{ route('updateRole', ['id' => $user->id]) }}">
                                    @csrf
                                    <button type="submit" name="role" value="super_admin" class="nav-link role-profile mb-0 px-0 py-1 d-flex align-items-center justify-content-center {{ $user->role == 'super_admin' ? 'active' : '' }}">
                                        <i class="ni ni-settings-gear-65"></i>
                                        <span class="ms-2">Expert</span>
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="alert">
        @include('components.alert')
    </div>
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-md-8 pb-3">
                <div class="card">
                    <div class="card-header pb-0">
                        <form role="form" method="POST" action={{ route('users.update', $user->id) }} enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="d-flex align-items-center">
                                <p class="mb-0">Edit Profile</p>
                                <button type="submit" class="btn btn-info btn-sm ms-auto">Save</button>
                            </div>
                        </div>
                        <div class="card-body">
                            <p class="text-uppercase text-sm">User Information</p>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Username</label>
                                        <input class="form-control" type="text" name="username" value="{{ old('username', $user->username) }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Email address</label>
                                        <input class="form-control" type="email" name="email" value="{{ old('email', $user->email) }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">First name</label>
                                        <input class="form-control" type="text" name="firstname"  value="{{ old('firstname', $user->firstname) }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Last name</label>
                                        <input class="form-control" type="text" name="lastname" value="{{ old('lastname', $user->lastname) }}">
                                    </div>
                                </div>
                            </div>
                            <hr class="horizontal dark">
                            <p class="text-uppercase text-sm">Contact Information</p>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Address</label>
                                        <input class="form-control" type="text" name="address"
                                            value="{{ old('address', $user->address) }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">City</label>
                                        <input class="form-control" type="text" name="city" value="{{ old('city', $user->city) }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Country</label>
                                        <input class="form-control" type="text" name="country" value="{{ old('country', $user->country) }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Postal code</label>
                                        <input class="form-control" type="text" name="postal" value="{{ old('postal', $user->postal) }}">
                                    </div>
                                </div>
                            </div>
                            <hr class="horizontal dark">
                            <p class="text-uppercase text-sm">About me</p>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">About me</label>
                                        <input class="form-control" type="text" name="about"
                                            value="{{ old('about', $user->about) }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-profile">
                    <div class="card card-plain">
                        <div class="card-header pb-0 text-start">
                            <h4 class="font-weight-bolder">Change password</h4>
                            <p class="mb-0">Set a new password for your email</p>
                        </div>
                        <div class="card-body">
                            <form role="form" method="POST" action="{{ route('change.perform') }}">
                                @csrf

                                <div class="flex flex-col mb-3">
                                    <input type="email" name="email" class="form-control form-control-lg" placeholder="Email" value="{{ old('email') }}" aria-label="Email">
                                    @error('email') <p class="text-danger text-xs pt-1"> {{$message}} </p>@enderror
                                </div>
                                <div class="flex flex-col mb-3">
                                    <input type="password" name="password" class="form-control form-control-lg" placeholder="Password" aria-label="Password" >
                                    @error('password') <p class="text-danger text-xs pt-1"> {{$message}} </p>@enderror
                                </div>
                                <div class="flex flex-col mb-3">
                                    <input type="password" name="confirm-password" class="form-control form-control-lg" placeholder="Password" aria-label="Password"  >
                                    @error('confirm-password') <p class="text-danger text-xs pt-1"> {{$message}} </p>@enderror
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-lg btn-info btn-lg w-100 mt-4 mb-0">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('layouts.footers.auth.footer')
    </div>
@endsection