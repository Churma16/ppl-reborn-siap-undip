@extends('dashboard-dosen.layouts.main')


@section('content')
    <div class="container-fluid px-2 px-md-4 mt-6">
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
                                Mahasiswa Perwalian Aktif
                            </p>
                            <h4 class="mb-0">data</h4>
                        </div>
                    </div>
                    <hr class="dark horizontal my-0" />
                    <div class="card-footer p-3">
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
                            <i class="material-icons opacity-10">people</i>
                        </div>
                        <div class="text-end pt-1">
                            <p class="text-sm mb-0 text-capitalize">
                                Mahasiswa Perwalian PKL
                            </p>
                            <h4 class="mb-0">{{ $muridPerwalianPkl }}</h4>
                        </div>
                    </div>
                    <hr class="dark horizontal my-0" />
                    <div class="card-footer p-3">
                        <p class="mb-0">
                            <span class="text-success text-sm font-weight-bolder">+3% </span>than last month
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-header p-3 pt-2">
                        <div
                            class="icon icon-lg icon-shape bg-gradient-success shadow-success text-center border-radius-xl mt-n4 position-absolute">
                            <i class="material-icons opacity-10">person</i>
                        </div>
                        <div class="text-end pt-1">
                            <p class="text-sm mb-0 text-capitalize">
                                Mahasiswa Perwalian Skripsi
                            </p>
                            <h4 class="mb-0">{{ $muridPerwalianSkripsi }}</h4>
                        </div>
                    </div>
                    <hr class="dark horizontal my-0" />
                    <div class="card-footer p-3">
                        <p class="mb-0">
                            <span class="text-danger text-sm font-weight-bolder">-2%</span>
                            than yesterday
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6">
                <div class="card">
                    <div class="card-header p-3 pt-2">
                        <div
                            class="icon icon-lg icon-shape bg-gradient-info shadow-info text-center border-radius-xl mt-n4 position-absolute">
                            <i class="material-icons opacity-10">person_off</i>
                        </div>
                        <div class="text-end pt-1">
                            <p class="text-sm mb-0 text-capitalize">
                                Mahasiswa Perwalian Non-Aktif
                            </p>
                            <h4 class="mb-0">$103,430</h4>
                        </div>
                    </div>
                    <hr class="dark horizontal my-0" />
                    <div class="card-footer p-3">
                        <p class="mb-0">
                            <span class="text-success text-sm font-weight-bolder">+5% </span>than yesterday
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="card card-body  mt-4">
            <div class="row gx-4 mb-2">
                <div class="col-auto">
                    <div class="avatar avatar-xl position-relative">
                        <img src="{{ $dosen->foto_dosen }}" alt="profile_image" class="w-100 border-radius-lg shadow-sm">
                    </div>
                </div>
                <div class="col-auto my-auto">
                    <div class="h-100">
                        <h5 class="mb-1">
                            {{ $dosen->nama }}
                        </h5>
                        <p class="mb-0 font-weight-normal text-sm">
                            {{ $dosen->nip }}
                        </p>
                    </div>
                </div>

            </div>
            <div class="row">
                <div class="row">
                    <div class="col ">
                        <div class="card card-plain">
                            <div class="card-body p-3">
                                <h6>Profile Information</h6>
                                <div class="row justify-content-center">
                                    <div class="col-6">
                                        <hr class="horizontal gray-light my-1">
                                        <ul class="list-group">
                                            <li class="list-group-item border-0 ps-0 pt-0 "><strong
                                                    class="text-dark">Kode
                                                    Wali:</strong> &nbsp; {{ $dosen->kode_wali }}</li>
                                            <li class="list-group-item border-0 ps-0 "><strong class="text-dark">No
                                                    HP:</strong> &nbsp; {{ $dosen->no_hp }}</li>
                                            <li class="list-group-item border-0 ps-0 "><strong
                                                    class="text-dark">Email:</strong>
                                                &nbsp; <a href="/cdn-cgi/l/email-protection" class="__cf_email__"
                                                    data-cfemail="a6c7cac3c5d2cec9cbd6d5c9c8e6cbc7cfca88c5c9cb">{{ $dosen->email }}</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-md-6">
                                        <ul class="list-group">
                                            <li class="list-group-item border-0 ps-0 pt-0 "><strong
                                                    class="text-dark">Departemen:</strong> &nbsp; Informatika</li>
                                            <li class="list-group-item border-0 ps-0 "><strong
                                                    class="text-dark">Fakultas:</strong> &nbsp; Sains dan Matematika</li>
                                        </ul>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
@endsection
