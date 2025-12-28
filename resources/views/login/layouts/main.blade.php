<!--
=========================================================
* Material Dashboard 2 - v3.1.0
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
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="/img/logo-undip.png">
    <link rel="icon" type="image/png" href="/img/logo-undip.png">
    <title>
        Login - Siap Undip
    </title>

    @yield('styles')
    <link rel="canonical" href="{{ url('/') }}" />

    <meta name="keywords" content="siap undip, student information system, undip dashboard, academic portal">
    <meta name="description"
        content="Siap Undip adalah sistem informasi akademik terintegrasi untuk mahasiswa Universitas Diponegoro.">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Siap Undip - Login">
    <meta name="twitter:description"
        content="Siap Undip adalah sistem informasi akademik terintegrasi untuk mahasiswa Universitas Diponegoro.">

    <meta property="og:title" content="Siap Undip - Login" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{ url('/') }}" />
    <meta property="og:description"
        content="Siap Undip adalah sistem informasi akademik terintegrasi untuk mahasiswa Universitas Diponegoro." />
    <meta property="og:site_name" content="Siap Undip" />

    <link rel="stylesheet" type="text/css"
        href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />

    <link href="/assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="/assets/css/nucleo-svg.css" rel="stylesheet" />

    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">

    <link id="pagestyle" href="/assets/css/material-dashboard.css?v=3.1.0" rel="stylesheet" />

    <!-- Sweet Alert 2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <style>
        .async-hide {
            opacity: 0 !important
        }
    </style>

    <script defer data-site="demos.creative-tim.com" src="https://api.nepcha.com/js/nepcha-analytics.js"></script>
</head>

<body class="bg-gray-200">
    @include('login.partials.navbar')

    <main class="main-content  mt-0">
        <div class="page-header align-items-start min-vh-100"
            style="background-image: url('/img/backgroundUndip.png'); background-color: rgba(16, 30, 70, 0.8);">
            @yield('content')

            @include('login.partials.footer')
        </div>
    </main>

    <!-- Sweet Alert 2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    <script src="/assets/js/core/popper.min.js"></script>
    <script src="/assets/js/core/bootstrap.min.js"></script>
    <script src="/assets/js/plugins/perfect-scrollbar.min.js"></script>
    <script src="/assets/js/plugins/smooth-scrollbar.min.js"></script>
    <script>
        var win = navigator.platform.indexOf('Win') > -1;
        if (win && document.querySelector('#sidenav-scrollbar')) {
            var options = {
                damping: '0.5'
            }
            Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
        }
    </script>

    <script src="/assets/js/material-dashboard.min.js?v=3.1.0"></script>
    @yield('scripts')
</body>

</html>
