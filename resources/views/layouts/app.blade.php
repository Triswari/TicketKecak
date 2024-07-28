<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="/img/favicon_kecak.png">
    <link rel="icon" type="image/png" href="/img/favicon_kecak.png">
    <title>
        Kecak and Barong The Nusa Dua
    </title>
    <!--     Fonts and icons     -->
    <link href="https://unicons.iconscout.com/release/v4.0.0/css/line.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <!-- Nucleo Icons -->
    <link href="/assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="/assets/css/nucleo-svg.css" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <link href="/assets/css/nucleo-svg.css" rel="stylesheet" />
    <!-- CSS Files -->
    <link rel="stylesheet" href="/assets/css/calculator.css">
    <link rel="stylesheet" href="/assets/css/note.css">
    <link id="pagestyle" href="/assets/css/ticket-dashboard.css" rel="stylesheet" />
    <!-- Chart -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body class="{{ $class ?? '' }}">

    @guest
        @yield('content')
    @endguest

    @auth
        @if (in_array(request()->route()->getName(), ['sign-in-static', 'sign-up-static', 'login', 'register', 'recover-password', 'rtl', 'virtual-reality']))
            @yield('content')
        @else
            @if (!in_array(request()->route()->getName(), ['profile', 'profile-static', 'home']))
                <div class="min-height-300 bg-dark position-absolute w-100"></div>
            @elseif (in_array(request()->route()->getName(), ['profile-static', 'profile', 'home']))
            <div class="position-absolute w-100 min-height-300 top-0" style="background-image: url('https://product-image.globaltix.com/live-gtImage/f512b195-ee63-427f-b1db-7245cde4cd07'); background-position-y: 87%; background-position-x: 50%; background-size: 100%;">
                    <span class="mask bg-dark opacity-6"></span>
                </div>
            @endif
            @include('layouts.navbars.auth.sidenav')
                <main class="main-content border-radius-lg">

                    @yield('content')
                </main>
            @include('components.fixed-plugin')

        @endif
    @endauth

    <!--   Core JS Files   -->
    <script src="/assets/js/core/popper.min.js"></script>
    <script src="/assets/js/core/bootstrap.min.js"></script>
    <script src="/assets/js/plugins/perfect-scrollbar.min.js"></script>
    <script src="/assets/js/plugins/smooth-scrollbar.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        var win = navigator.platform.indexOf('Win') > -1;
        if (win && document.querySelector('#sidenav-scrollbar')) {
            var options = {
                damping: '0.5'
            }
            Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
        }
    </script>
    <!-- Github buttons -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="/assets/js/note.js"></script>
    <script src="/assets/js/calculator.js"></script>
    <script src="/assets/js/ticket-dashboard.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.0/js/bootstrap.bundle.min.js"></script>
    <!-- JS dark mode -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (localStorage.getItem('darkMode') === 'true') {
                document.body.classList.add('dark-version');
                document.getElementById('dark-version').checked = true;
            }
        });
        function darkMode(toggle) {
            if (toggle.checked) {
                document.body.classList.add('dark-version');
                localStorage.setItem('darkMode', 'true');
            } else {
                document.body.classList.remove('dark-version');
                localStorage.setItem('darkMode', 'false');
            }
        }
    </script>

    <!-- Chart -->
    <script src="/assets/js/visitorChart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
    @stack('js')
</body>

</html>