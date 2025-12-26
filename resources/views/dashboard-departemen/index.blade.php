{{-- @dd($mahasiswa->aktif_pkl) --}}
@extends('dashboard-departemen.layouts.main')


@section('content')
    <div class="row">
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
                <div class="card-header p-3 pt-2">
                    <div
                        class="icon icon-lg icon-shape bg-gradient-dark shadow-dark text-center border-radius-xl mt-n4 position-absolute">
                        <i class="material-icons opacity-10">group</i>
                    </div>
                    <div class="text-end pt-1">
                        <p class="text-sm mb-0 text-capitalize">
                            Rerata Ipk Semester Lalu
                        </p>
                        <h4 class="mb-0">{{ $rerataMhsSemesterLalu }}</h4>
                    </div>
                </div>
                <hr class="dark horizontal my-0" />

                <div class="card-footer px-4 py-2">
                    <p class="mb-0">
                        <span class="text-success text-sm font-weight-bolder">+55% </span>than last week
                    </p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
                <div class="card-header p-3 pt-2">
                    <div
                        class="icon icon-lg icon-shape bg-gradient-primary shadow-primary text-center border-radius-xl mt-n4 position-absolute">
                        <i class="material-icons opacity-10">school</i>
                    </div>
                    <div class="text-end pt-1">
                        <p class="text-sm mb-0 text-capitalize">
                            Calon Wisuda
                        </p>
                        <h4 class="mb-0">{{ $calonWisudaCount }}</h4>
                    </div>
                </div>
                <hr class="dark horizontal my-0" />
                <div class="card-footer px-4 py-2">
                    <p class="mb-0">
                        <span
                            class="text-{{ $calonWisudaDiff < 0 ? 'danger' : 'success' }} text-sm font-weight-bolder">{{ $calonWisudaDiff }}
                        </span>dibanding semester lalu
                    </p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
                <div class="card-header p-3 pt-2">
                    <div
                        class="icon icon-lg icon-shape bg-gradient-danger shadow-danger text-center border-radius-xl mt-n4 position-absolute">
                        <i class="material-icons opacity-10">warning</i>
                    </div>
                    <div class="text-end pt-1">
                        <p class="text-sm mb-0 text-capitalize">
                            Mahasiswa Kritis
                        </p>
                        <h4 class="mb-0">{{ $mhsKritis }}</h4>
                    </div>
                </div>
                <hr class="dark horizontal my-0" />
                <div class="card-footer px-4 py-2">
                    <p class="mb-0">
                        semester > 2 dengan ipk < 2.00 </p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6">
            <div class="card">
                <div class="card-header p-3 pt-2">
                    <div
                        class="icon icon-lg icon-shape bg-gradient-info shadow-info text-center border-radius-xl mt-n4 position-absolute">
                        <i class="material-icons opacity-10">percent</i>
                    </div>
                    <div class="text-end pt-1">
                        <p class="text-sm mb-0 text-capitalize">
                            Rasio Dosen/Mahasiswa
                        </p>
                        <h4 class="mb-0 {{ $rasioColor }}">{{ $rasioDosenMahasiswa }}</h4>
                    </div>
                </div>
                <hr class="dark horizontal my-0" />
                <div class="card-footer px-4 py-2">
                    <p class="mb-0 ">
                        Beban Terberat: {{ $bebanDoswal->keys()->first() }} </p>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-8">
            <div class="card">
                <div class="card-body">
                    <h5>Monitoring Tingkat Akhir</h5>
                    <div class="chart">
                        <canvas id="chart-pkl-skripsi" class="chart-canvas" height="200"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="card">
                <div class="card-body">
                    <h5>Beban Dosen</h5>
                    <div class="chart">
                        <canvas id="chart-beban-dosen" class="chart-canvas" height="200"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <h5>Daftar Mahasiswa Perlu Perhatian</h5>
                    <div class="table-responsive">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-sm font-weight-bolder ">Nama
                                    </th>

                                    <th class="text-center text-uppercase text-secondary text-sm font-weight-bolder ">
                                        Angkatan
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-sm font-weight-bolder  ps-2">
                                        Semester</th>
                                    <th class="text-center text-uppercase text-secondary text-sm font-weight-bolder ">
                                        IPK</th>
                                    <th class="text-center text-uppercase text-secondary text-sm font-weight-bolder ">
                                        SKS</th>
                                    <th class="text-center ">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    @foreach ($listMhsKritis as $mhsKritis)
                                        <td class="">
                                            <h6 class="text-secondary text-xs ps-2">{{ $mhsKritis->nama }}</h6>
                                        </td>
                                        <td class="align-middle text-center">

                                            <span
                                                class="text-secondary text-xs font-weight-normal">{{ $mhsKritis->angkatan }}</span>
                                        </td>
                                        <td class="align-middle text-center">

                                            <span
                                                class="text-secondary text-xs font-weight-normal">{{ $mhsKritis->khsTerakhir->semester }}</span>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <span
                                                class="text-secondary text-xs font-weight-normal">{{ $mhsKritis->khsTerakhir->ip_kumulatif }}</span>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span
                                                class="text-secondary text-xs font-weight-normal">{{ $mhsKritis->khsTerakhir->sks_kumulatif }}</span>
                                        </td>
                                        <td class="align-middle text-center ">
                                            <a class="btn btn-outline-info px-2 py-1" href="mailto:{{ $mhsKritis->email }}"
                                                title="Kirim Email">
                                                <i class="material-icons opacity-10">mail</i>
                                            </a>
                                        </td>
                                </tr>
                                @endforeach


                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-4">
        <div>
            <h3>
                Data Praktik Kerja Lapangan (PKL)
            </h3>
        </div>
        <div class="col-lg-6 col-md-6 mt-4 mb-4">
            <div class="card z-index-2">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 bg-transparent">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg py-3 pe-1">
                        <div class="chart">
                            <canvas id="pie-chart-pkl-status" class="chart-canvas" height="300px"></canvas>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <h6 class="mb-0">Data Status PKL</h6>
                    <p class="text-sm">Last Campaign Performance</p>
                    <hr class="dark horizontal" />
                    <div class="d-flex">
                        <i class="material-icons text-sm my-auto me-1">schedule</i>
                        <p class="mb-0 text-sm">
                            campaign sent 2 days ago
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 mt-4 mb-4">
            <div class="card z-index-2">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 bg-transparent">
                    <div class="bg-gradient-success shadow-success border-radius-lg py-3 pe-1">
                        <div class="chart">
                            <canvas id="pie-chart-pkl-kelulusan" class="chart-canvas" height="300px"></canvas>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <h6 class="mb-0">Data Kelulusan PKL</h6>
                    <p class="text-sm">
                        (<span class="font-weight-bolder">+15%</span>) increase in today sales.
                    </p>
                    <hr class="dark horizontal" />
                    <div class="d-flex">
                        <i class="material-icons text-sm my-auto me-1">schedule</i>
                        <p class="mb-0 text-sm">
                            updated 4 min ago
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-4">
        <div>
            <h3>
                Data Skripsi
            </h3>
        </div>
        <div class="col-lg-6 col-md-6 mt-4 mb-4">
            <div class="card z-index-2">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 bg-transparent">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg py-3 pe-1">
                        <div class="chart">
                            <canvas id="pie-chart-skripsi-status" class="chart-canvas" height="300px"></canvas>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <h6 class="mb-0">Data Status Skripsi</h6>
                    <p class="text-sm">Last Campaign Performance</p>
                    <hr class="dark horizontal" />
                    <div class="d-flex">
                        <i class="material-icons text-sm my-auto me-1">schedule</i>
                        <p class="mb-0 text-sm">
                            campaign sent 2 days ago
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 mt-4 mb-4">
            <div class="card z-index-2">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 bg-transparent">
                    <div class="bg-gradient-success shadow-success border-radius-lg py-3 pe-1">
                        <div class="chart">
                            <canvas id="pie-chart-skripsi-kelulusan" class="chart-canvas" height="300px"></canvas>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <h6 class="mb-0">Data Kelulusan Skripsi</h6>
                    <p class="text-sm">
                        (<span class="font-weight-bolder">+15%</span>) increase in today sales.
                    </p>
                    <hr class="dark horizontal" />
                    <div class="d-flex">
                        <i class="material-icons text-sm my-auto me-1">schedule</i>
                        <p class="mb-0 text-sm">
                            updated 4 min ago
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-lg-4 col-md-6 mt-4 mb-4">
            <div class="card z-index-2">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 bg-transparent">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg py-3 pe-1">
                        <div class="chart">
                            <canvas id="chart-bars" class="chart-canvas" height="170"></canvas>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <h6 class="mb-0">Website Views</h6>
                    <p class="text-sm">Last Campaign Performance</p>
                    <hr class="dark horizontal" />
                    <div class="d-flex">
                        <i class="material-icons text-sm my-auto me-1">schedule</i>
                        <p class="mb-0 text-sm">
                            campaign sent 2 days ago
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 mt-4 mb-4">
            <div class="card z-index-2">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 bg-transparent">
                    <div class="bg-gradient-success shadow-success border-radius-lg py-3 pe-1">
                        <div class="chart">
                            <canvas id="chart-line" class="chart-canvas" height="170"></canvas>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <h6 class="mb-0">Daily Sales</h6>
                    <p class="text-sm">
                        (<span class="font-weight-bolder">+15%</span>) increase in today sales.
                    </p>
                    <hr class="dark horizontal" />
                    <div class="d-flex">
                        <i class="material-icons text-sm my-auto me-1">schedule</i>
                        <p class="mb-0 text-sm">
                            updated 4 min ago
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 mt-4 mb-3">
            <div class="card z-index-2">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 bg-transparent">
                    <div class="bg-gradient-dark shadow-dark border-radius-lg py-3 pe-1">
                        <div class="chart">
                            <canvas id="chart-line-tasks" class="chart-canvas" height="170"></canvas>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <h6 class="mb-0">Completed Tasks</h6>
                    <p class="text-sm">Last Campaign Performance</p>
                    <hr class="dark horizontal" />
                    <div class="d-flex">
                        <i class="material-icons text-sm my-auto me-1">schedule</i>
                        <p class="mb-0 text-sm">just updated</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mb-4">
        <div class="col-lg-8 col-md-6 mb-md-0 mb-4">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="row">
                        <div class="col-lg-6 col-7">
                            <h6>Projects</h6>
                            <p class="text-sm mb-0">
                                <i class="fa fa-check text-info" aria-hidden="true"></i>
                                <span class="font-weight-bold ms-1">30 done</span>
                                this month
                            </p>
                        </div>
                        <div class="col-lg-6 col-5 my-auto text-end">
                            <div class="dropdown float-lg-end pe-4">
                                <a class="cursor-pointer" id="dropdownTable" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    <i class="fa fa-ellipsis-v text-secondary"></i>
                                </a>
                                <ul class="dropdown-menu px-2 py-3 ms-sm-n4 ms-n5" aria-labelledby="dropdownTable">
                                    <li>
                                        <a class="dropdown-item border-radius-md" href="javascript:;">Action</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item border-radius-md" href="javascript:;">Another
                                            action</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item border-radius-md" href="javascript:;">Something else
                                            here</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body px-0 pb-2">
                    <div class="table-responsive">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Companies
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Members
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Budget
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Completion
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="d-flex px-2 py-1">
                                            <div>
                                                <img src="/assets/img/small-logos/logo-xd.svg"
                                                    class="avatar avatar-sm me-3" alt="xd" />
                                            </div>
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">
                                                    Material XD
                                                    Version
                                                </h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="avatar-group mt-2">
                                            <a href="javascript:;" class="avatar avatar-xs rounded-circle"
                                                data-bs-toggle="tooltip" data-bs-placement="bottom" title="Ryan Tompson">
                                                <img src="/assets/img/team-1.jpg" alt="team1" />
                                            </a>
                                            <a href="javascript:;" class="avatar avatar-xs rounded-circle"
                                                data-bs-toggle="tooltip" data-bs-placement="bottom" title="Romina Hadid">
                                                <img src="/assets/img/team-2.jpg" alt="team2" />
                                            </a>
                                            <a href="javascript:;" class="avatar avatar-xs rounded-circle"
                                                data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                title="Alexander Smith">
                                                <img src="/assets/img/team-3.jpg" alt="team3" />
                                            </a>
                                            <a href="javascript:;" class="avatar avatar-xs rounded-circle"
                                                data-bs-toggle="tooltip" data-bs-placement="bottom" title="Jessica Doe">
                                                <img src="/assets/img/team-4.jpg" alt="team4" />
                                            </a>
                                        </div>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <span class="text-xs font-weight-bold">
                                            $14,000
                                        </span>
                                    </td>
                                    <td class="align-middle">
                                        <div class="progress-wrapper w-75 mx-auto">
                                            <div class="progress-info">
                                                <div class="progress-percentage">
                                                    <span class="text-xs font-weight-bold">60%</span>
                                                </div>
                                            </div>
                                            <div class="progress">
                                                <div class="progress-bar bg-gradient-info w-60" role="progressbar"
                                                    aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="d-flex px-2 py-1">
                                            <div>
                                                <img src="/assets/img/small-logos/logo-atlassian.svg"
                                                    class="avatar avatar-sm me-3" alt="atlassian" />
                                            </div>
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">
                                                    Add Progress
                                                    Track
                                                </h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="avatar-group mt-2">
                                            <a href="javascript:;" class="avatar avatar-xs rounded-circle"
                                                data-bs-toggle="tooltip" data-bs-placement="bottom" title="Romina Hadid">
                                                <img src="/assets/img/team-2.jpg" alt="team5" />
                                            </a>
                                            <a href="javascript:;" class="avatar avatar-xs rounded-circle"
                                                data-bs-toggle="tooltip" data-bs-placement="bottom" title="Jessica Doe">
                                                <img src="/assets/img/team-4.jpg" alt="team6" />
                                            </a>
                                        </div>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <span class="text-xs font-weight-bold">
                                            $3,000
                                        </span>
                                    </td>
                                    <td class="align-middle">
                                        <div class="progress-wrapper w-75 mx-auto">
                                            <div class="progress-info">
                                                <div class="progress-percentage">
                                                    <span class="text-xs font-weight-bold">10%</span>
                                                </div>
                                            </div>
                                            <div class="progress">
                                                <div class="progress-bar bg-gradient-info w-10" role="progressbar"
                                                    aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="d-flex px-2 py-1">
                                            <div>
                                                <img src="/assets/img/small-logos/logo-slack.svg"
                                                    class="avatar avatar-sm me-3" alt="team7" />
                                            </div>
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">
                                                    Fix Platform
                                                    Errors
                                                </h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="avatar-group mt-2">
                                            <a href="javascript:;" class="avatar avatar-xs rounded-circle"
                                                data-bs-toggle="tooltip" data-bs-placement="bottom" title="Romina Hadid">
                                                <img src="/assets/img/team-3.jpg" alt="team8" />
                                            </a>
                                            <a href="javascript:;" class="avatar avatar-xs rounded-circle"
                                                data-bs-toggle="tooltip" data-bs-placement="bottom" title="Jessica Doe">
                                                <img src="/assets/img/team-1.jpg" alt="team9" />
                                            </a>
                                        </div>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <span class="text-xs font-weight-bold">
                                            Not set
                                        </span>
                                    </td>
                                    <td class="align-middle">
                                        <div class="progress-wrapper w-75 mx-auto">
                                            <div class="progress-info">
                                                <div class="progress-percentage">
                                                    <span class="text-xs font-weight-bold">100%</span>
                                                </div>
                                            </div>
                                            <div class="progress">
                                                <div class="progress-bar bg-gradient-success w-100" role="progressbar"
                                                    aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="d-flex px-2 py-1">
                                            <div>
                                                <img src="/assets/img/small-logos/logo-spotify.svg"
                                                    class="avatar avatar-sm me-3" alt="spotify" />
                                            </div>
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">
                                                    Launch our
                                                    Mobile App
                                                </h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="avatar-group mt-2">
                                            <a href="javascript:;" class="avatar avatar-xs rounded-circle"
                                                data-bs-toggle="tooltip" data-bs-placement="bottom" title="Ryan Tompson">
                                                <img src="/assets/img/team-4.jpg" alt="user1" />
                                            </a>
                                            <a href="javascript:;" class="avatar avatar-xs rounded-circle"
                                                data-bs-toggle="tooltip" data-bs-placement="bottom" title="Romina Hadid">
                                                <img src="/assets/img/team-3.jpg" alt="user2" />
                                            </a>
                                            <a href="javascript:;" class="avatar avatar-xs rounded-circle"
                                                data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                title="Alexander Smith">
                                                <img src="/assets/img/team-4.jpg" alt="user3" />
                                            </a>
                                            <a href="javascript:;" class="avatar avatar-xs rounded-circle"
                                                data-bs-toggle="tooltip" data-bs-placement="bottom" title="Jessica Doe">
                                                <img src="/assets/img/team-1.jpg" alt="user4" />
                                            </a>
                                        </div>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <span class="text-xs font-weight-bold">
                                            $20,500
                                        </span>
                                    </td>
                                    <td class="align-middle">
                                        <div class="progress-wrapper w-75 mx-auto">
                                            <div class="progress-info">
                                                <div class="progress-percentage">
                                                    <span class="text-xs font-weight-bold">100%</span>
                                                </div>
                                            </div>
                                            <div class="progress">
                                                <div class="progress-bar bg-gradient-success w-100" role="progressbar"
                                                    aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="d-flex px-2 py-1">
                                            <div>
                                                <img src="/assets/img/small-logos/logo-jira.svg"
                                                    class="avatar avatar-sm me-3" alt="jira" />
                                            </div>
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">
                                                    Add the New
                                                    Pricing Page
                                                </h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="avatar-group mt-2">
                                            <a href="javascript:;" class="avatar avatar-xs rounded-circle"
                                                data-bs-toggle="tooltip" data-bs-placement="bottom" title="Ryan Tompson">
                                                <img src="/assets/img/team-4.jpg" alt="user5" />
                                            </a>
                                        </div>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <span class="text-xs font-weight-bold">
                                            $500
                                        </span>
                                    </td>
                                    <td class="align-middle">
                                        <div class="progress-wrapper w-75 mx-auto">
                                            <div class="progress-info">
                                                <div class="progress-percentage">
                                                    <span class="text-xs font-weight-bold">25%</span>
                                                </div>
                                            </div>
                                            <div class="progress">
                                                <div class="progress-bar bg-gradient-info w-25" role="progressbar"
                                                    aria-valuenow="25" aria-valuemin="0" aria-valuemax="25"></div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="d-flex px-2 py-1">
                                            <div>
                                                <img src="/assets/img/small-logos/logo-invision.svg"
                                                    class="avatar avatar-sm me-3" alt="invision" />
                                            </div>
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">
                                                    Redesign New
                                                    Online Shop
                                                </h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="avatar-group mt-2">
                                            <a href="javascript:;" class="avatar avatar-xs rounded-circle"
                                                data-bs-toggle="tooltip" data-bs-placement="bottom" title="Ryan Tompson">
                                                <img src="/assets/img/team-1.jpg" alt="user6" />
                                            </a>
                                            <a href="javascript:;" class="avatar avatar-xs rounded-circle"
                                                data-bs-toggle="tooltip" data-bs-placement="bottom" title="Jessica Doe">
                                                <img src="/assets/img/team-4.jpg" alt="user7" />
                                            </a>
                                        </div>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <span class="text-xs font-weight-bold">
                                            $2,000
                                        </span>
                                    </td>
                                    <td class="align-middle">
                                        <div class="progress-wrapper w-75 mx-auto">
                                            <div class="progress-info">
                                                <div class="progress-percentage">
                                                    <span class="text-xs font-weight-bold">40%</span>
                                                </div>
                                            </div>
                                            <div class="progress">
                                                <div class="progress-bar bg-gradient-info w-40" role="progressbar"
                                                    aria-valuenow="40" aria-valuemin="0" aria-valuemax="40"></div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6">
            <div class="card h-100">
                <div class="card-header pb-0">
                    <h6>Orders overview</h6>
                    <p class="text-sm">
                        <i class="fa fa-arrow-up text-success" aria-hidden="true"></i>
                        <span class="font-weight-bold">24%</span>
                        this month
                    </p>
                </div>
                <div class="card-body p-3">
                    <div class="timeline timeline-one-side">
                        <div class="timeline-block mb-3">
                            <span class="timeline-step">
                                <i class="material-icons text-success text-gradient">notifications</i>
                            </span>
                            <div class="timeline-content">
                                <h6 class="text-dark text-sm font-weight-bold mb-0">
                                    $2400, Design changes
                                </h6>
                                <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">
                                    22 DEC 7:20 PM
                                </p>
                            </div>
                        </div>
                        <div class="timeline-block mb-3">
                            <span class="timeline-step">
                                <i class="material-icons text-danger text-gradient">code</i>
                            </span>
                            <div class="timeline-content">
                                <h6 class="text-dark text-sm font-weight-bold mb-0">
                                    New order #1832412
                                </h6>
                                <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">
                                    21 DEC 11 PM
                                </p>
                            </div>
                        </div>
                        <div class="timeline-block mb-3">
                            <span class="timeline-step">
                                <i class="material-icons text-info text-gradient">shopping_cart</i>
                            </span>
                            <div class="timeline-content">
                                <h6 class="text-dark text-sm font-weight-bold mb-0">
                                    Server payments for April
                                </h6>
                                <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">
                                    21 DEC 9:34 PM
                                </p>
                            </div>
                        </div>
                        <div class="timeline-block mb-3">
                            <span class="timeline-step">
                                <i class="material-icons text-warning text-gradient">credit_card</i>
                            </span>
                            <div class="timeline-content">
                                <h6 class="text-dark text-sm font-weight-bold mb-0">
                                    New card added for order
                                    #4395133
                                </h6>
                                <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">
                                    20 DEC 2:20 AM
                                </p>
                            </div>
                        </div>
                        <div class="timeline-block mb-3">
                            <span class="timeline-step">
                                <i class="material-icons text-primary text-gradient">key</i>
                            </span>
                            <div class="timeline-content">
                                <h6 class="text-dark text-sm font-weight-bold mb-0">
                                    Unlock packages for development
                                </h6>
                                <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">
                                    18 DEC 4:54 AM
                                </p>
                            </div>
                        </div>
                        <div class="timeline-block">
                            <span class="timeline-step">
                                <i class="material-icons text-dark text-gradient">payments</i>
                            </span>
                            <div class="timeline-content">
                                <h6 class="text-dark text-sm font-weight-bold mb-0">
                                    New order #9583120
                                </h6>
                                <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">
                                    17 DEC
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        var ctx = document.getElementById("chart-bars").getContext("2d");

        new Chart(ctx, {
            type: "bar",
            data: {
                labels: ["M", "T", "W", "T", "F", "S", "S"],
                datasets: [{
                    label: "Sales",
                    tension: 0.4,
                    borderWidth: 0,
                    borderRadius: 4,
                    borderSkipped: false,
                    backgroundColor: "rgba(255, 255, 255, .8)",
                    data: [50, 20, 10, 22, 50, 10, 40],
                    maxBarThickness: 6,
                }, ],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false,
                    },
                },
                interaction: {
                    intersect: false,
                    mode: "index",
                },
                scales: {
                    y: {
                        grid: {
                            drawBorder: false,
                            display: true,
                            drawOnChartArea: true,
                            drawTicks: false,
                            borderDash: [5, 5],
                            color: "rgba(255, 255, 255, .2)",
                        },
                        ticks: {
                            suggestedMin: 0,
                            suggestedMax: 500,
                            beginAtZero: true,
                            padding: 10,
                            font: {
                                size: 14,
                                weight: 300,
                                family: "Roboto",
                                style: "normal",
                                lineHeight: 2,
                            },
                            color: "#fff",
                        },
                    },
                    x: {
                        grid: {
                            drawBorder: false,
                            display: true,
                            drawOnChartArea: true,
                            drawTicks: false,
                            borderDash: [5, 5],
                            color: "rgba(255, 255, 255, .2)",
                        },
                        ticks: {
                            display: true,
                            color: "#f8f9fa",
                            padding: 10,
                            font: {
                                size: 14,
                                weight: 300,
                                family: "Roboto",
                                style: "normal",
                                lineHeight: 2,
                            },
                        },
                    },
                },
            },
        });

        var ctx2 = document.getElementById("chart-line").getContext("2d");

        new Chart(ctx2, {
            type: "line",
            data: {
                labels: [
                    "Apr",
                    "May",
                    "Jun",
                    "Jul",
                    "Aug",
                    "Sep",
                    "Oct",
                    "Nov",
                    "Dec",
                ],
                datasets: [{
                    label: "Mobile apps",
                    tension: 0,
                    borderWidth: 0,
                    pointRadius: 5,
                    pointBackgroundColor: "rgba(255, 255, 255, .8)",
                    pointBorderColor: "transparent",
                    borderColor: "rgba(255, 255, 255, .8)",
                    borderColor: "rgba(255, 255, 255, .8)",
                    borderWidth: 4,
                    backgroundColor: "transparent",
                    fill: true,
                    data: [50, 40, 300, 320, 500, 350, 200, 230, 500],
                    maxBarThickness: 6,
                }, ],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false,
                    },
                },
                interaction: {
                    intersect: false,
                    mode: "index",
                },
                scales: {
                    y: {
                        grid: {
                            drawBorder: false,
                            display: true,
                            drawOnChartArea: true,
                            drawTicks: false,
                            borderDash: [5, 5],
                            color: "rgba(255, 255, 255, .2)",
                        },
                        ticks: {
                            display: true,
                            color: "#f8f9fa",
                            padding: 10,
                            font: {
                                size: 14,
                                weight: 300,
                                family: "Roboto",
                                style: "normal",
                                lineHeight: 2,
                            },
                        },
                    },
                    x: {
                        grid: {
                            drawBorder: false,
                            display: false,
                            drawOnChartArea: false,
                            drawTicks: false,
                            borderDash: [5, 5],
                        },
                        ticks: {
                            display: true,
                            color: "#f8f9fa",
                            padding: 10,
                            font: {
                                size: 14,
                                weight: 300,
                                family: "Roboto",
                                style: "normal",
                                lineHeight: 2,
                            },
                        },
                    },
                },
            },
        });

        var ctx3 = document
            .getElementById("chart-line-tasks")
            .getContext("2d");

        new Chart(ctx3, {
            type: "line",
            data: {
                labels: [
                    "Apr",
                    "May",
                    "Jun",
                    "Jul",
                    "Aug",
                    "Sep",
                    "Oct",
                    "Nov",
                    "Dec",
                ],
                datasets: [{
                    label: "Mobile apps",
                    tension: 0,
                    borderWidth: 0,
                    pointRadius: 5,
                    pointBackgroundColor: "rgba(255, 255, 255, .8)",
                    pointBorderColor: "transparent",
                    borderColor: "rgba(255, 255, 255, .8)",
                    borderWidth: 4,
                    backgroundColor: "transparent",
                    fill: true,
                    data: [50, 40, 300, 220, 500, 250, 400, 230, 500],
                    maxBarThickness: 6,
                }, ],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false,
                    },
                },
                interaction: {
                    intersect: false,
                    mode: "index",
                },
                scales: {
                    y: {
                        grid: {
                            drawBorder: false,
                            display: true,
                            drawOnChartArea: true,
                            drawTicks: false,
                            borderDash: [5, 5],
                            color: "rgba(255, 255, 255, .2)",
                        },
                        ticks: {
                            display: true,
                            padding: 10,
                            color: "#f8f9fa",
                            font: {
                                size: 14,
                                weight: 300,
                                family: "Roboto",
                                style: "normal",
                                lineHeight: 2,
                            },
                        },
                    },
                    x: {
                        grid: {
                            drawBorder: false,
                            display: false,
                            drawOnChartArea: false,
                            drawTicks: false,
                            borderDash: [5, 5],
                        },
                        ticks: {
                            display: true,
                            color: "#f8f9fa",
                            padding: 10,
                            font: {
                                size: 14,
                                weight: 300,
                                family: "Roboto",
                                style: "normal",
                                lineHeight: 2,
                            },
                        },
                    },
                },
            },
        });

        // Pie chart PKL Status
        var ctx4 = document.getElementById("pie-chart-pkl-status").getContext("2d");

        new Chart(ctx4, {
            type: "pie",
            data: {
                labels: ['Sudah Ambil', 'Belum Ambil'],
                datasets: [{
                    label: "Projects",
                    weight: 9,
                    cutout: 0,
                    tension: 0.9,
                    pointRadius: 2,
                    borderWidth: 1,
                    backgroundColor: ['#17c1e8', '#3A416F'],
                    data: [
                        {{ $mahasiswa->jumlah_status_pkl['sudah_ambil'] . ',' . $mahasiswa->jumlah_status_pkl['belum_ambil'] }}
                    ],
                    fill: false
                }],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false,
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index',
                },
                scales: {
                    y: {
                        grid: {
                            drawBorder: false,
                            display: false,
                            drawOnChartArea: false,
                            drawTicks: false,
                        },
                        ticks: {
                            display: false
                        }
                    },
                    x: {
                        grid: {
                            drawBorder: false,
                            display: false,
                            drawOnChartArea: false,
                            drawTicks: false,
                        },
                        ticks: {
                            display: false,
                        }
                    },
                },
            },
        });

        // Pie Chart PKL Kelulusan
        var ctx5 = document.getElementById("pie-chart-pkl-kelulusan").getContext("2d");

        new Chart(ctx5, {
            type: "pie",
            data: {
                labels: ['Lulus', 'Belum Lulus'],
                datasets: [{
                    label: "Kelulusan",
                    weight: 9,
                    cutout: 0,
                    tension: 0.9,
                    pointRadius: 2,
                    borderWidth: 1,
                    backgroundColor: ['#17c1e8', '#3A416F'],
                    data: [
                        {{ $pkl->jumlah_kelulusan['lulus'] . ',' . $pkl->jumlah_kelulusan['belum_lulus'] }}
                    ],
                    fill: false
                }],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false,
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index',
                },
                scales: {
                    y: {
                        grid: {
                            drawBorder: false,
                            display: false,
                            drawOnChartArea: false,
                            drawTicks: false,
                        },
                        ticks: {
                            display: false
                        }
                    },
                    x: {
                        grid: {
                            drawBorder: false,
                            display: false,
                            drawOnChartArea: false,
                            drawTicks: false,
                        },
                        ticks: {
                            display: false,
                        }
                    },
                },
            },
        });

        // Pie Chart Skripsi Status
        var ctx6 = document.getElementById("pie-chart-skripsi-status").getContext("2d");

        new Chart(ctx6, {
            type: "pie",
            data: {
                labels: ['Sudah Ambil', 'Belum Ambil'],
                datasets: [{
                    label: "Status",
                    weight: 9,
                    cutout: 0,
                    tension: 0.9,
                    pointRadius: 2,
                    borderWidth: 1,
                    backgroundColor: ['#17c1e8', '#3A416F'],
                    data: [
                        {{ $mahasiswa->jumlah_status_skripsi['sudah_ambil'] . ',' . $mahasiswa->jumlah_status_skripsi['belum_ambil'] }}
                    ],
                    fill: false
                }],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false,
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index',
                },
                scales: {
                    y: {
                        grid: {
                            drawBorder: false,
                            display: false,
                            drawOnChartArea: false,
                            drawTicks: false,
                        },
                        ticks: {
                            display: false
                        }
                    },
                    x: {
                        grid: {
                            drawBorder: false,
                            display: false,
                            drawOnChartArea: false,
                            drawTicks: false,
                        },
                        ticks: {
                            display: false,
                        }
                    },
                },
            },
        });

        // Pie Chart Skripsi Kelulusan
        var ctx7 = document.getElementById("pie-chart-skripsi-kelulusan").getContext("2d");

        new Chart(ctx7, {
            type: "pie",
            data: {
                labels: ['Lulus', 'Belum Lulus'],
                datasets: [{
                    label: "Kelulusan",
                    weight: 9,
                    cutout: 0,
                    tension: 0.9,
                    pointRadius: 2,
                    borderWidth: 1,
                    backgroundColor: ['#17c1e8', '#3A416F'],
                    data: [
                        {{ $skripsi->jumlah_kelulusan['lulus'] . ',' . $skripsi->jumlah_kelulusan['belum_lulus'] }}
                    ],
                    fill: false
                }],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false,
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index',
                },
                scales: {
                    y: {
                        grid: {
                            drawBorder: false,
                            display: false,
                            drawOnChartArea: false,
                            drawTicks: false,
                        },
                        ticks: {
                            display: false
                        }
                    },
                    x: {
                        grid: {
                            drawBorder: false,
                            display: false,
                            drawOnChartArea: false,
                            drawTicks: false,
                        },
                        ticks: {
                            display: false,
                        }
                    },
                },
            },
        });


        var ctx3 = document.getElementById("chart-pkl-skripsi").getContext("2d");

        new Chart(ctx3, {
            type: "bar",
            data: {
                // Label Sumbu Y (Kategori)
                labels: ["PKL", "Skripsi"],
                datasets: [{
                        label: "Sudah Lulus",
                        data: [
                            {{ $statusPklCount['lulus'] }}, // Data PKL Lulus
                            {{ $statusSkripsiCount['lulus'] }} // Data Skripsi Lulus
                        ],
                        backgroundColor: "#66BB6A", // Hijau
                        barThickness: 40, // Batang lebih tebal biar enak dilihat
                    },
                    {
                        label: "Sedang Proses",
                        data: [
                            {{ $statusPklCount['progress'] }}, // Data PKL Proses
                            {{ $statusSkripsiCount['progress'] }} // Data Skripsi Proses
                        ],
                        backgroundColor: "#FFA726", // Kuning
                        barThickness: 40,
                    },
                    {
                        label: "Belum Ambil",
                        data: [
                            {{ $statusPklCount['belum_ambil'] }}, // Data PKL Proses
                            {{ $statusSkripsiCount['belum_ambil'] }} // Data Skripsi Proses
                        ],
                        backgroundColor: "#e94440", // Kuning
                        barThickness: 40,
                    },
                ],
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                    }
                },
                scales: {
                    x: {
                        stacked: true,
                        grid: {
                            drawBorder: false,
                            display: true,
                            color: "#f0f2f5",
                        },
                        ticks: {
                            display: true,
                            color: "#b2b9bf",
                        }
                    },
                    y: {
                        stacked: true,
                        grid: {
                            drawBorder: false,
                            display: false,
                        },
                        ticks: {
                            color: "#344767",
                            font: {
                                weight: 600, // Tebalkan font label "PKL" & "Skripsi"
                                size: 14
                            }
                        }
                    },
                },
            },
        });

        var ctx5 = document.getElementById("chart-beban-dosen").getContext("2d");

        new Chart(ctx5, {
            type: "bar", // Tipe Bar Biasa (Vertikal)
            data: {
                labels: @json($bebanDoswal->keys()), // Dummy data
                datasets: [{
                    label: "Jumlah Mahasiswa",
                    tension: 0.4,
                    borderWidth: 0,
                    borderRadius: 4,
                    borderSkipped: false,
                    backgroundColor: "#344767", // Warna Gelap (Dark Blue) biar elegan
                    data: @json($bebanDoswal->values()), // Dummy data
                    maxBarThickness: 60 // Jangan terlalu gemuk barnya
                }],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false, // Tidak butuh legend karena cuma 1 kategori
                    }
                },
                scales: {
                    y: {
                        grid: {
                            drawBorder: true,
                            display: true,
                            drawOnChartArea: true,
                            drawTicks: false,
                            borderDash: [5, 5],
                            color: '#c1c4ce5c'
                        },
                        ticks: {
                            display: true,
                            color: "#b2b9bf",
                        }
                    },
                    x: {
                        grid: {
                            drawBorder: false,
                            display: false,
                            drawOnChartArea: false,
                            drawTicks: false,
                            borderDash: [5, 5]
                        },
                        ticks: {
                            display: true,
                            color: "#344767", // Warna Nama Dosen
                            padding: 10,
                            font: {
                                size: 11, // Agak kecil biar nama panjang muat
                                family: "Roboto",
                                style: 'normal',
                                lineHeight: 2
                            },
                        },
                    },
                },
            },
        });
    </script>
@endsection
