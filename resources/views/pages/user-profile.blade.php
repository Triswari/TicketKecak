@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Your Profile'])
    <div class="card shadow-lg mx-4 card-profile-bottom">
        <div class="card-body p-3">
            <div class="row gx-4">
                <div class="col-auto">
                    <div class="avatar avatar-xl position-relative">
                        <img src="/img/kecak_barong_nusa_dua_logo.png" alt="profile_image" class="w-100 border-radius-lg shadow-sm">
                    </div>
                </div>
                <div class="col-auto my-auto">
                    <div class="h-100">
                        <h5 class="mb-1">
                            {{ auth()->user()->firstname ?? 'Firstname' }} {{ auth()->user()->lastname ?? 'Lastname' }}
                        </h5>
                        <p class="mb-0 font-weight-bold text-sm">
                            @php
                                $role = auth()->user()->role ?? 'Role';
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
                        <form role="form" method="POST" action={{ route('profile.update') }} enctype="multipart/form-data">
                            @csrf
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
                                        <input class="form-control" type="text" name="username" value="{{ old('username', auth()->user()->username) }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Email address</label>
                                        <input class="form-control" type="email" name="email" value="{{ old('email', auth()->user()->email) }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">First name</label>
                                        <input class="form-control" type="text" name="firstname"  value="{{ old('firstname', auth()->user()->firstname) }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Last name</label>
                                        <input class="form-control" type="text" name="lastname" value="{{ old('lastname', auth()->user()->lastname) }}">
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
                                            value="{{ old('address', auth()->user()->address) }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">City</label>
                                        <input class="form-control" type="text" name="city" value="{{ old('city', auth()->user()->city) }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Country</label>
                                        <input class="form-control" type="text" name="country" value="{{ old('country', auth()->user()->country) }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Postal code</label>
                                        <input class="form-control" type="text" name="postal" value="{{ old('postal', auth()->user()->postal) }}">
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
                                            value="{{ old('about', auth()->user()->about) }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            @if(in_array(Auth::user()->role, ['super_admin', 'admin']))
            <div class="col-md-4">
                <div class="card card-profile">
                    <div class="card card-plain">
                        <div class="card-header pb-0 text-start">
                            <h4 class="font-weight-bolder">Change password</h4>
                            <p class="mb-0">Set a new password for your email</p>
                        </div>
                        <div class="card-body">
                            <form id="changeForm" role="form" method="POST" action="{{ route('change.perform') }}">
                                @csrf
                                <div class="flex flex-col mb-3">
                                    <input type="email" name="email" class="form-control form-control-lg" placeholder="Email" value="{{ old('email') }}" aria-label="Email">
                                    @error('email') <p class="text-danger text-xs pt-1"> {{$message}} </p>@enderror
                                </div>
                                <div class="flex flex-col mb-3">
                                    <input type="password" id="password" name="password" class="form-control form-control-lg" placeholder="Password" aria-label="Password" >
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
            @endif
            @if(Auth::user()->role == 'user')
            <div class="col-md-4">
                <div class="card card-profile">
                    <img src="/img/show_kecak.png" alt="Image placeholder" class="card-img-top">
                    <div class="row justify-content-center">
                        <div class="col-4 col-lg-4 order-lg-2">
                            <div class="mt-n4 mt-lg-n6 mb-4 mb-lg-0">
                                <a href="javascript:;">
                                    <img src="/img/kecak_barong_nusa_dua_logo.png"
                                        class="rounded-circle img-fluid border border-2 border-white">
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-header text-center border-0 pt-0 pt-lg-4 pb-4 pb-lg-2">
                        <div class="d-flex justify-content-center">
                            <form action="{{ route('send.request') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-dark float-right mb-0 d-none d-lg-block">Send Request</button>
                            </form>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <div class="text-center mt-4">
                            <h5>
                                Hello, <span class="">{{ auth()->user()->username }}</span>
                            </h5>
                            <div class="h6 font-weight-300">
                                <i class="ni location_pin mr-2"></i>Send Request to become an admin
                            </div>
                            <div class="h6 mt-4">
                                <i class="ni business_briefcase-24 mr-2"></i>current status [{{ auth()->user()->role }}]
                            </div>
                            <div>
                                <i class="ni education_hat mr-2"></i>Bali Langen The Nusa Dua
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            <!-- <div class="row col-md-4">
            <div class="col-md-12">
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
            @if(Auth::user()->role == 'super_admin')
            <div class="col-md-12">
                <div class="card card-profile">
                    <div class="card card-plain">
                        <div class="card-header pb-0 text-start">
                            <h4 class="font-weight-bolder">Code Access</h4>
                            <p class="mb-0">Send code access to new admin</p>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('access-codes.store') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="email">Email:</label>
                                    <input type="email" id="email" name="email" class="form-control" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Generate and Send Access Code</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            </div> -->
        </div>
        @include('layouts.footers.auth.footer')
    </div>

<!-- Change password -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('changeForm').addEventListener('submit', function(event) {
            const password = document.getElementById('password').value;
            
            
            const regexLowercase = /[a-z]/;
            const regexUppercase = /[A-Z]/;
            const regexNumber = /[0-9]/;
            const regexSpecial = /[@$!%*#?&]/;

            if (password.length < 8) {
                alert('The password must consist of a minimum of 8 characters.');
                event.preventDefault();
            } else if (!regexLowercase.test(password)) {
                alert('The password must contain lowercase letters.');
                event.preventDefault();
            } else if (!regexUppercase.test(password)) {
                alert('The password must contain uppercase letters.');
                event.preventDefault();
            } else if (!regexNumber.test(password)) {
                alert('The password must contain numbers.');
                event.preventDefault();
            } else if (!regexSpecial.test(password)) {
                alert('The password must contain special characters.');
                event.preventDefault();
            }
        });
    });
</script>
@endsection