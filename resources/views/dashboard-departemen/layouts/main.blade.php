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
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="apple-touch-icon" sizes="76x76" href="/img/logo-undip.png" />
    <link rel="icon" type="image/png" href="/img/logo-undip.png" />
    <title>{{ $title }} - Siap Undip</title>

    <!--     Fonts and icons     -->
    <link rel="stylesheet" type="text/css"
        href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />
    <!-- Nucleo Icons -->
    <link href="/assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="/assets/css/nucleo-svg.css" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet" />
    <!-- CSS Files -->
    <link id="pagestyle" href="/assets/css/material-dashboard.css?v=3.0.5" rel="stylesheet" />

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    {{-- <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css"> --}}

    <!-- Nepcha Analytics (nepcha.com) -->
    <!-- Nepcha is a easy-to-use web analytics. No cookies and fully compliant with GDPR, CCPA and PECR. -->
    <script defer data-site="YOUR_DOMAIN_HERE" src="https://api.nepcha.com/js/nepcha-analytics.js"></script>
    @yield('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

    <style>
        /*--- Custom DataTables Pagination Styles ---*/

        /* 1. Default Page Link Styling */
        .dataTables_wrapper .page-link {
            color: #344767;
            /* Dark blue text color from your theme */
            border: 1px solid #dee2e6;
            /* Standard light border */
            background-color: #fff;
            border-radius: 0.375rem;
            /* Matches other button border-radius */
            margin: 0 2px;
            /* Slight spacing between buttons */
            transition: all 0.3s ease;
        }

        /* 2. Remove default focus outline */
        .dataTables_wrapper .page-link:focus {
            box-shadow: none;
        }

        /* 3. Hover State for Page Links */
        .dataTables_wrapper .page-link:hover {
            color: #fff;
            background-color: #f3722c;
            /* Your theme's orange accent color */
            border-color: #f3722c;
        }

        /* 4. Active Page Styling (The current page) */
        .dataTables_wrapper .page-item.active .page-link {
            z-index: 3;
            color: #fff !important;
            background-color: #f3722c !important;
            /* Your theme's orange accent color */
            border-color: #f3722c !important;
        }

        /* 5. Disabled Page Link Styling (e.g., "Previous" on page 1) */
        .dataTables_wrapper .page-item.disabled .page-link {
            color: #6c757d;
            pointer-events: none;
            background-color: #fff;
            border-color: #dee2e6;
            opacity: 0.6;
        }

        /* 6. Adjust Pagination Container Spacing */
        .dataTables_wrapper .dataTables_paginate {
            padding-top: 1rem;
        }

        /* --- PERBAIKAN TOMBOL PREVIOUS & NEXT --- */

        /* Target khusus untuk tombol Previous dan Next */
        .dataTables_wrapper .page-item.previous .page-link,
        .dataTables_wrapper .page-item.next .page-link {
            width: auto !important;
            /* Biarkan lebar menyesuaikan teks */
            height: auto !important;
            /* Biarkan tinggi menyesuaikan */
            border-radius: 10px !important;
            /* Bentuk lonjong (bukan lingkaran) */
            padding: 6px 15px !important;
            /* Beri jarak teks ke pinggir */
            font-size: 0.8rem;
            /* Ukuran font sedikit dikecilkan agar rapi */
            font-weight: bold;
        }

        /* Pastikan tombol angka tetap bulat */
        .dataTables_wrapper .page-item:not(.previous):not(.next) .page-link {
            width: 36px;
            height: 36px;
            border-radius: 50% !important;
            /* Lingkaran sempurna */
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* --- BEAUTIFY SHOW ENTRIES & SEARCH --- */

        /* 1. Styling Dropdown "Show Entries" */
        .dataTables_wrapper .dataTables_length select {
            border: 1px solid #d2d6da !important;
            /* Border abu halus */
            border-radius: 0.375rem !important;
            /* Sudut melengkung */
            padding: 5px 10px !important;
            color: #495057;
            background-color: #fff;
            cursor: pointer;
            outline: none;
            transition: all 0.2s ease;
        }

        /* 2. Styling Kotak Pencarian (Search) */
        .dataTables_wrapper .dataTables_filter input {
            border: 1px solid #d2d6da !important;
            border-radius: 0.375rem !important;
            padding: 5px 10px !important;
            margin-left: 5px;
            outline: none;
            transition: all 0.2s ease;
        }

        /* 3. Efek FOKUS Oranye (Saat diklik) */
        .dataTables_wrapper .dataTables_length select:focus,
        .dataTables_wrapper .dataTables_filter input:focus {
            border-color: #f3722c !important;
            /* Warna Oranye Tema Anda */
            box-shadow: 0 0 0 2px rgba(243, 114, 44, 0.25) !important;
            /* Efek kilau oranye transparan */
        }

        /* 4. Merapikan Label Teks (Show .. entries) */
        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter {
            color: #7b809a;
            /* Warna teks abu-abu sekunder yang pas dimata */
            font-size: 0.875rem;
            margin-bottom: 10px;
            /* Beri jarak sedikit ke tabel */
        }
    </style>
</head>

<body class="g-sidenav-show bg-gray-200">
    <!-- Sidenav -->
    @include('dashboard-departemen.partials.sidenav')
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



    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="/assets/js/core/popper.min.js"></script>
    <script src="/assets/js/core/bootstrap.min.js"></script>
    <script src="/assets/js/plugins/perfect-scrollbar.min.js"></script>
    <script src="/assets/js/plugins/smooth-scrollbar.min.js"></script>

    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script src="/assets/js/material-dashboard.min.js?v=3.0.5"></script>
    <script async defer src="https://buttons.github.io/buttons.js"></script>

    <script>
        var win = navigator.platform.indexOf("Win") > -1;
        if (win && document.querySelector("#sidenav-scrollbar")) {
            var options = {
                damping: "0.5"
            };
            Scrollbar.init(document.querySelector("#sidenav-scrollbar"), options);
        }
    </script>

    @yield('scripts')
</body>

</html>
