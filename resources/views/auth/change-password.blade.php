@extends('layouts.app')

@section('content')
    <div class="container position-sticky z-index-sticky top-0">
        <div class="row">
            <div class="col-12">
                @include('layouts.navbars.guest.navbar')
            </div>
        </div>
    </div>
    <main class="main-content  mt-0">
        <section>
            <div class="page-header min-vh-100">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-4 col-lg-5 col-md-7 d-flex flex-column mx-lg-0 mx-auto">
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
                                            <button type="submit" class="btn btn-lg btn-dark btn-lg w-100 mt-4 mb-0">Submit</button>
                                        </div>
                                    </form>
                                </div>
                                <div id="alert">
                                    @include('components.alert')
                                </div>
                            </div>
                        </div>
                        <div
                            class="col-6 d-lg-flex d-none h-100 my-auto pe-0 position-absolute top-0 end-0 text-center justify-content-center flex-column">
                            <div class="position-relative bg-gradient-dark h-100 m-3 px-7 border-radius-lg d-flex flex-column justify-content-center overflow-hidden"
                                style="background-image: url('https://product-image.globaltix.com/live-gtImage/942afe90-5716-45a7-86d7-0c43c8dee7e6');
              background-size: cover; background-position-x: 40%">
                                <span class="mask bg-gradient-dark opacity-6"></span>
                                <h3 class="mt-5 text-white font-weight-bolder position-relative">"Kecak and Barong Dance Show The Nusa Dua"</h3>
                                <p class="text-white position-relative">Delve into the legendary saga of Sri Rama, Dewi Sinta, and the tyrannical Rahwana, 
                                    portrayed with intricate choreography and mesmerizing music.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
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