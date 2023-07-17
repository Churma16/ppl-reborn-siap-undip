{{-- @dd($ipk); --}}
@extends('dashboard-mahasiswa.layouts.main')
@section('content')
    <div class="container-fluid px-2 px-md-4 mt-4">
        <div class="row">
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-header p-3 pt-2">
                        <div
                            class="icon icon-lg icon-shape bg-gradient-primary shadow-primary text-center border-radius-xl mt-n4 position-absolute">
                            <i class="material-icons opacity-10">event_note</i>
                        </div>
                        <div class="text-end pt-1">
                            <p class="text-sm mb-0 text-capitalize">
                                Semester
                            </p>
                            <h4 class="mb-0">{{ $semesterAktif }}</h4>
                        </div>
                    </div>
                    <div class="card-footer py-1">
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-header p-3 pt-2">
                        <div
                            class="icon icon-lg icon-shape bg-gradient-dark shadow-dark text-center border-radius-xl mt-n4 position-absolute">
                            <i class="material-icons opacity-10">emoji_events</i>
                        </div>
                        <div class="text-end pt-1">
                            <p class="text-sm mb-0 text-capitalize">
                                IP Kumulatif
                            </p>
                            <h4 class="mb-0">{{ $ipk }}</h4>
                        </div>
                    </div>
                    <div class="card-footer p-1">
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-header p-3 pt-2">
                        <div
                            class="icon icon-lg icon-shape bg-gradient-success shadow-success text-center border-radius-xl mt-n4 position-absolute">
                            <i class="material-icons opacity-10">playlist_add_check </i>
                        </div>
                        <div class="text-end pt-1">
                            <p class="text-sm mb-0 text-capitalize">
                                SKS Kumulatif
                            </p>
                            <h4 class="mb-0">{{ $sksk }}</h4>
                        </div>
                    </div>
                    <div class="card-footer p-1">
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6">
                <div class="card">
                    <div class="card-header p-3 pt-2">
                        <div
                            class="icon icon-lg icon-shape bg-gradient-info shadow-info text-center border-radius-xl mt-n4 position-absolute">
                            <i class="material-icons opacity-10">supervisor_account</i>
                        </div>
                        <div class="text-end pt-1">
                            <p class="text-sm mb-0 text-capitalize">
                                Dosen Wali
                            </p>
                            <h4 class="mb-0">{{ $mahasiswa->dosen->nama }}</h4>
                        </div>
                    </div>
                    <div class="card-footer p-1">
                    </div>
                </div>
            </div>
        </div>
        <div class="card card-body  mt-4">
            <div class="row gx-4 mb-2 ms-1">
                <div class="col-auto">
                    <div class="avatar avatar-xl position-relative">
                        <img src="/assets/img/bruce-mars.jpg" alt="profile_image" class="w-100 border-radius-lg shadow-sm">
                    </div>
                </div>
                <div class="col-auto my-auto">
                    <div class="h-100">
                        <h4 class="mb-1">
                            {{ $mahasiswa->nama }}
                        </h4>
                        <p class="mb-0 font-weight-normal text-sm">
                            {{ $mahasiswa->nim }}
                        </p>
                    </div>
                </div>

            </div>
            <div class="row">
                <div class="row">
                    <div class="col-12 col-xl-12">
                        <div class="card card-plain">
                            <div class="card-body p-3">
                                <h5 class="mb-2">Data Diri</h5>
                                <div class="row justify-content-center">
                                    <div class="col-md-6">
                                        <hr class="horizontal gray-light my-1">
                                        <ul class="list-group">
                                            <li class="list-group-item border-0 ps-0 pt-0 "><strong
                                                    class="text-dark">Angkatan:</strong> &nbsp; {{ $mahasiswa->angkatan }}
                                            </li>
                                            <li class="list-group-item border-0 ps-0 "><strong
                                                    class="text-dark">Jalur Masuk:</strong> &nbsp;
                                                {{ $mahasiswa->jalur_masuk }}</li>
                                            <li class="list-group-item border-0 ps-0 "><strong
                                                    class="text-dark">Jurusan:</strong> &nbsp;
                                                Informatika</li>
                                            <li class="list-group-item border-0 ps-0 "><strong
                                                    class="text-dark">Fakultas:</strong> &nbsp;
                                                Sains dan Matematika</li>
                                        </ul>
                                    </div>
                                    <div class="col-md-6">
                                        <ul class="list-group">
                                            <li class="list-group-item border-0 ps-0 pt-0 "><strong
                                                    class="text-dark">Email:</strong> &nbsp; {{ $mahasiswa->email }}</li>
                                            <li class="list-group-item border-0 ps-0 "><strong class="text-dark">No
                                                    HP:</strong> &nbsp; {{ $mahasiswa->no_hp }}</li>
                                            <li class="list-group-item border-0 ps-0 "><strong
                                                    class="text-dark">Alamat:</strong>&nbsp; {{ $mahasiswa->alamat }}
                                            </li>
                                            <li class="list-group-item border-0 ps-0 "><strong
                                                    class="text-dark">Provinsi:</strong> &nbsp;
                                                {{ $mahasiswa->provinsi->nama }}</li>
                                            <li class="list-group-item border-0 ps-0 "><strong
                                                    class="text-dark">Kabupaten:</strong> &nbsp;
                                                {{ $mahasiswa->kabupaten->nama }}</li>
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
