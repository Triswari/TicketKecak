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
                <div class="col-xl-4 col-lg-5 col-md-7 mx-auto mb-5">
                    <div class="card z-index-0">
                        <div class="card-header text-center pt-4">
                            <h5>Register</h5>
                        </div>
                        <div class="row px-xl-5 px-sm-4 px-3">
                            <div class="col-12 me-auto px-1">
                                <a class="btn btn-outline-light w-100 text-dark d-flex justify-content-center" href="{{ url('auth/google') }}">
                                    <svg width="24px" height="32px" viewBox="0 0 64 64" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <g transform="translate(3.000000, 2.000000)" fill-rule="nonzero">
                                                <path
                                                    d="M57.8123233,30.1515267 C57.8123233,27.7263183 57.6155321,25.9565533 57.1896408,24.1212666 L29.4960833,24.1212666 L29.4960833,35.0674653 L45.7515771,35.0674653 C45.4239683,37.7877475 43.6542033,41.8844383 39.7213169,44.6372555 L39.6661883,45.0037254 L48.4223791,51.7870338 L49.0290201,51.8475849 C54.6004021,46.7020943 57.8123233,39.1313952 57.8123233,30.1515267"
                                                    fill="#4285F4"></path>
                                                <path
                                                    d="M29.4960833,58.9921667 C37.4599129,58.9921667 44.1456164,56.3701671 49.0290201,51.8475849 L39.7213169,44.6372555 C37.2305867,46.3742596 33.887622,47.5868638 29.4960833,47.5868638 C21.6960582,47.5868638 15.0758763,42.4415991 12.7159637,35.3297782 L12.3700541,35.3591501 L3.26524241,42.4054492 L3.14617358,42.736447 C7.9965904,52.3717589 17.959737,58.9921667 29.4960833,58.9921667"
                                                    fill="#34A853"></path>
                                                <path
                                                    d="M12.7159637,35.3297782 C12.0932812,33.4944915 11.7329116,31.5279353 11.7329116,29.4960833 C11.7329116,27.4640054 12.0932812,25.4976752 12.6832029,23.6623884 L12.6667095,23.2715173 L3.44779955,16.1120237 L3.14617358,16.2554937 C1.14708246,20.2539019 0,24.7439491 0,29.4960833 C0,34.2482175 1.14708246,38.7380388 3.14617358,42.736447 L12.7159637,35.3297782"
                                                    fill="#FBBC05"></path>
                                                <path
                                                    d="M29.4960833,11.4050769 C35.0347044,11.4050769 38.7707997,13.7975244 40.9011602,15.7968415 L49.2255853,7.66898166 C44.1130815,2.91684746 37.4599129,0 29.4960833,0 C17.959737,0 7.9965904,6.62018183 3.14617358,16.2554937 L12.6832029,23.6623884 C15.0758763,16.5505675 21.6960582,11.4050769 29.4960833,11.4050769"
                                                    fill="#EB4335"></path>
                                            </g>
                                        </g>
                                    </svg><p class="px-2 m-0 text-dark d-flex align-items-center">Sign up with google</p>
                                </a>
                            </div>
                            <div class="mt-2 position-relative text-center">
                                <p
                                    class="text-sm font-weight-bold mb-2 text-secondary text-border d-inline z-index-2 bg-white px-3">
                                    or
                                </p>
                            </div>
                        </div>
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
                                    <i class="fas fa-eye toggle-password" id="togglePassword" style="position: absolute; right: 40px; top: 336px; cursor: pointer;"></i>  
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
