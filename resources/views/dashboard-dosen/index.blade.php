@extends('dashboard-dosen.layouts.main')


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
                            Mahasiswa Perwalian Aktif
                        </p>
                        <h4 class="mb-0">{{ $jumlahPerwalianAktifSmtLatest }}</h4>
                    </div>
                </div>
                <hr class="dark horizontal my-0" />
                <div class="card-footer p-3">
                    <p class="mb-0">
                        <span
                            class="text-{{ $perwalianDiff < 0 ? 'success' : 'danger' }} text-sm font-weight-bolder">{{ $perwalianDiff }}
                        </span>
                        student than last semester
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
                        <h4 class="mb-0">{{ $perwalianPklAktifNow }}</h4>
                    </div>
                </div>
                <hr class="dark horizontal my-0" />
                <div class="card-footer p-3">
                    <p class="mb-0">
                        <span class="text-{{ $perwalianPklDiff < 0 ? 'success' : 'danger' }} text-sm font-weight-bolder">
                            {{ $perwalianPklDiff }}
                        </span>student than last semester
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
                        <h4 class="mb-0">{{ $perwalianSkripsiAktifNow }}</h4>
                    </div>
                </div>
                <hr class="dark horizontal my-0" />
                <div class="card-footer p-3">
                    <p class="mb-0">
                        <span
                            class="text-{{ $perwalianPklDiff < 0 ? 'success' : 'danger' }} text-sm font-weight-bolder">{{ $perwalianSkripsiDiff }}</span>
                        student than last semester
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
                        <h4 class="mb-0">{{ $perwalianTidakAktifSmtNow }}</h4>
                    </div>
                </div>
                <hr class="dark horizontal my-0" />
                <div class="card-footer p-3">
                    <p class="mb-0">
                        <span
                            class="text-{{ $perwalianTidakAktifDiff < 0 ? 'success' : 'danger' }} text-sm font-weight-bolder">
                            {{ $perwalianTidakAktifDiff }}
                        </span>students than last semester
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class=" mt-4">
        <div class="row">
            <div class="col-lg-9 ">
                <div class="card">
                    <div class="card-header">
                        <h5>Permintaan Validasi Baru</h5>
                        <hr class="dark horizontal my-0" />
                    </div>
                    <div class="card-body">
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="card">
                    <div class="card-header">
                        <h5>Jadwal Sidang Bulan Ini</h5>
                        <hr class="dark horizontal my-0" />
                    </div>
                    <div class="card-body mt-0 pt-0">
                        <div class="table-responsive">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Nama</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Tanggal Sidang</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($sidangTerdekats as $sidangTerdekat)
                                        <tr>
                                            <td>
                                                <div class="d-flex px-2">
                                                    <div class="my-auto ms-2">
                                                        <h6 class="mb-0 text-xs">{{ $sidangTerdekat->nama }}</h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                {{-- {{ dd($sidangTerdekat->skripsi->status_skripsi) }} --}}
                                                <p class="text-xs font-weight-normal mb-0">{{ $sidangTerdekat->skripsi->tanggal_sidang}}</p>
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
                                        <li class="list-group-item border-0 ps-0 pt-0 "><strong class="text-dark">Kode
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
                                        <li class="list-group-item border-0 ps-0 pt-0 "><strong class="text-dark">Kode
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
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#tabledata').DataTable();
        });
    </script>
@endsection
