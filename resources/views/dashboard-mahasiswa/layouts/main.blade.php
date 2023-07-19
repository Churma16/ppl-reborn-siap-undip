<!-- MATERIAL DASHBOARD 2 -->
<!--
=========================================================
* Material Dashboard 2 - v3.0.5
=========================================================

* Product Page: https://www.creative-tim.com/product/material-dashboard
* Copyright 2023 Creative Tim (https://www.creative-tim.com)
* Licensed under MIT (https://www.creative-tim.com/license)
* Coded by Creative Tim

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
-->
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="76x76" href="/img/logo-undip.png" />
    <link rel="icon" type="image/png" href="/img/logo-undip.png" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Page title -->
    <title>Dashboard Mahasiswa</title>

    <!-- Custom styles -->
    @yield('styles')

    <!-- Fonts and icons -->
    <link rel="stylesheet" type="text/css"
        href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />
    <link href="/assets/css/nucleo-icons.css" rel="stylesheet" /> <!-- Nucleo Icons -->
    <link href="/assets/css/nucleo-svg.css" rel="stylesheet" /> <!-- Nucleo SVG Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet" />


    {{-- <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css"> --}}


    <!-- Material Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script> <!-- Font Awesome Icons -->

    <!-- Material Dashboard CSS -->
    <link id="pagestyle" href="/assets/css/material-dashboard.css?v=3.0.5" rel="stylesheet" />

    <!-- Nepcha Analytics -->
    <script defer data-site="YOUR_DOMAIN_HERE" src="https://api.nepcha.com/js/nepcha-analytics.js"></script>

    <!-- Feather Icons -->
    <script src="https://unpkg.com/feather-icons"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


</head>

<body class="g-sidenav-show bg-gray-200">
    <!-- Sidenav -->
    @include('dashboard-mahasiswa.partials.sidenav')
    <!-- End Sidenav -->

    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <!-- Navbar -->
        @include('partials.navbar')
        <!-- End Navbar -->

        <div class="container-fluid py-4">
            @yield('content')
            @include('partials.footer')
        </div>
    </main>

    @include('partials.plugin')

    <!-- Core JS Files -->
    <script src="/assets/js/core/popper.min.js"></script>
    <script src="/assets/js/core/bootstrap.min.js"></script>
    <script src="/assets/js/plugins/perfect-scrollbar.min.js"></script>
    <script src="/assets/js/plugins/smooth-scrollbar.min.js"></script>
    <script src="/assets/js/plugins/chartjs.min.js"></script>

    <!-- Custom scripts -->
    @yield('scripts')

    <script>
        var win = navigator.platform.indexOf("Win") > -1;
        if (win && document.querySelector("#sidenav-scrollbar")) {
            var options = {
                damping: "0.5",
            };
            Scrollbar.init(document.querySelector("#sidenav-scrollbar"), options);
        }
    </script>

    <script>
        window.addEventListener('DOMContentLoaded', function() {
            var disabledInputs = document.querySelectorAll('input[disabled]');

            disabledInputs.forEach(function(input) {
                input.classList.add('bg-gray-100');

            });
        });
    </script>

    <!-- Github buttons -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>

    <!-- Material Dashboard JS -->
    <script src="/assets/js/material-dashboard.min.js?v=3.0.5"></script>

    <!-- Feather Icons -->
    <script>
        feather.replace()
    </script>

    <script src="https://cdn.datatables.net/v/dt/dt-1.13.5/datatables.min.js"></script>
</body>

</html>
