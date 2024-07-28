@extends('layouts.app')

@section('content')
    @include('layouts.navbars.guest.navbar')
    <main class="main-content  mt-0">
        <div class="page-header align-items-start min-vh-50 pt-5 pb-11 m-3 border-radius-lg"
            style="background-image: url('https://product-image.globaltix.com/live-gtImage/21a50204-e507-41b3-b355-2510b063951b'); background-position: top; background-position-y: 80%">
            <span class="mask bg-gradient-dark opacity-6"></span>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-5 text-center mx-auto">
                        <h1 class="text-white mb-2 mt-5">Welcome!</h1>
                        <p class="text-lead text-white">for those of you who have just joined, 
                            become part of Kecak and Barong Dance Show The Nusa Dua.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row mt-lg-n10 mt-md-n11 mt-n10 justify-content-center">
                <div class="col-xl-4 col-lg-5 col-md-7 mx-auto">
                    <div class="card z-index-0">
                        <div class="card-header text-center pt-4">
                            <h5>Register</h5>
                        </div>
                        <div class="row px-xl-5 px-sm-4 px-3">
                        </div>
                        <!-- <a href="{{ url('auth/google') }}" class="text-dark">
                            <div class="">
                                <div class="ms-2 fw-bold">
                                    login with google
                                </div>
                            </div>
                        <a> -->
                        <div class="card-body">
                            <form id="registerForm" method="POST" action="{{ route('register.perform') }}">
                                @csrf
                                <div class="flex flex-col mb-3">
                                    <input type="text" id="username" name="username" class="form-control" placeholder="Username" aria-label="Name" value="{{ old('username') }}" >
                                    
                                </div>
                                <div class="flex flex-col mb-3">
                                    <input type="email" id="email" name="email" class="form-control" placeholder="Email" aria-label="Email" value="{{ old('email') }}" >  
                                
                                </div>
                                <div class="flex flex-col mb-3">
                                    <input type="password" id="password" name="password" class="form-control" placeholder="Password" aria-label="Password">
                                    <i class="fas fa-eye toggle-password" id="togglePassword" style="position: absolute; right: 40px; top: 232px; cursor: pointer;"></i>  
                                </div>
                                @if ($errors->any())
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li><p class='text-danger text-xs pt-1 mb-0'> {{ $error }} </p></li>
                                        @endforeach
                                    </ul>
                                @endif
                                <div class="form-check form-check-info text-start">
                                    <input class="form-check-input" type="checkbox" name="terms" id="termsCheckbox">
                                    <label class="form-check-label" for="termsCheckbox">
                                        I agree to the <a href="javascript:;" class="text-dark font-weight-bolder">Terms and Conditions</a>
                                    </label>
                                    @error('terms') <p class='text-danger text-xs'> {{ $message }} </p> @enderror
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn bg-dark text-white w-100 my-4 mb-2" id="signUpButton" disabled>Sign up</button>
                                </div>
                                <p class="text-sm mt-3 mb-0">Already have an account? <a href="{{ route('login') }}"
                                        class="text-info text-gradient font-weight-bolder">Sign in</a></p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    @include('layouts.footers.guest.footer')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const termsCheckbox = document.getElementById('termsCheckbox');
            const signUpButton = document.getElementById('signUpButton');

            termsCheckbox.addEventListener('change', function () {
                signUpButton.disabled = !this.checked;
            });

            const togglePassword = document.querySelector('#togglePassword');
            const password = document.querySelector('#password');

            togglePassword.addEventListener('click', function (e) {
                // toggle the type attribute
                const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                password.setAttribute('type', type);
                // toggle the eye slash icon
                this.classList.toggle('fa-eye-slash');
            });
        });
    </script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('registerForm').addEventListener('submit', function(event) {
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