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
                            Perwalian Aktif
                        </p>
                        <h4 class="mb-0">{{ $jumlahPerwalianAktifSmtLatest }}</h4>
                    </div>
                </div>
                <hr class="dark horizontal my-0" />
                <div class="card-footer p-3">
                    <p class="mb-0">
                        <span
                            class="text-{{ $perwalianDiff > 0 ? 'success' : 'danger' }} text-sm font-weight-bolder">{{ $perwalianDiff }}
                        </span>
                        <span class="text-secondary text-sm">
                            vs sem. lalu</span>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
                <div class="card-header p-3 pt-2">
                    <div
                        class="icon icon-lg icon-shape bg-gradient-primary shadow-primary text-center border-radius-xl mt-n4 position-absolute">
                        <i class="material-icons opacity-10">work</i>
                    </div>
                    <div class="text-end pt-1">
                        <p class="text-sm mb-0 text-capitalize">
                            Perwalian PKL
                        </p>
                        <h4 class="mb-0">{{ $perwalianPklAktifNow }}</h4>
                    </div>
                </div>
                <hr class="dark horizontal my-0" />
                <div class="card-footer p-3">
                    <p class="mb-0">
                        <span class="text-{{ $perwalianPklDiff > 0 ? 'success' : 'danger' }} text-sm font-weight-bolder">
                            {{ $perwalianPklDiff }}
                        </span>vs Sem. Lalu
                    </p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
                <div class="card-header p-3 pt-2">
                    <div
                        class="icon icon-lg icon-shape bg-gradient-success shadow-success text-center border-radius-xl mt-n4 position-absolute">
                        <i class="material-icons opacity-10">school</i>
                    </div>
                    <div class="text-end pt-1">
                        <p class="text-sm mb-0 text-capitalize">
                            Perwalian Skripsi
                        </p>
                        <h4 class="mb-0">{{ $perwalianSkripsiAktifNow }}</h4>
                    </div>
                </div>
                <hr class="dark horizontal my-0" />
                <div class="card-footer p-3">
                    <p class="mb-0">
                        <span
                            class="text-{{ $perwalianPklDiff > 0 ? 'success' : 'danger' }} text-sm font-weight-bolder">{{ $perwalianSkripsiDiff }}</span>
                        vs Sem. Lalu
                    </p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6">
            <div class="card">
                <div class="card-header p-3 pt-2">
                    <div
                        class="icon icon-lg icon-shape bg-gradient-danger shadow-info text-center border-radius-xl mt-n4 position-absolute">
                        <i class="material-icons opacity-10">person_off</i>
                    </div>
                    <div class="text-end pt-1">
                        <p class="text-sm mb-0 text-capitalize text-wrap">
                            Perwalian Non-Aktif
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
            <div class="col-lg-8 ">
                <div class="card">
                    <div class="card-header">
                        <h5>Permintaan Validasi Baru</h5>
                        <hr class="dark horizontal my-0" />
                    </div>
                    <div class="card-body mt-0 pt-0">
                        <div class="table-responsive">
                            <table class="table align-items-center mb-0" id="validationRequestsTable">
                                @if ($permintaanTerbarus->isEmpty())
                                    <p class="text-center font-weight-bold">Tidak ada permintaan validasi baru.</p>
                                @else
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase text-secondary text-md font-weight-bolder opacity-7 "
                                                style="width: auto; white-space: nowrap;">
                                                Nama
                                            </th>
                                            <th
                                                class="text-uppercase text-secondary  text-md font-weight-bolder opacity-7 ps-2">
                                                Kategori</th>
                                            <th
                                                class="text-uppercase text-secondary  text-md font-weight-bolder opacity-7 ps-2">
                                                Tanggal<br> Permintaan</th>
                                            <th
                                                class="text-uppercase text-secondary text-center text-md font-weight-bolder opacity-7 ps-2">
                                                Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($permintaanTerbarus as $permintaanTerbaru)
                                            <tr>
                                                <td style="width: auto; white-space: nowrap;">
                                                    <div class="px-0">
                                                        <div class="my-auto ms-2">
                                                            <h6 class="mb-0 text-md">
                                                                {{ $permintaanTerbaru->mahasiswa->nama }}
                                                            </h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <p class="text-md font-weight-normal  mb-0">
                                                        {{ $permintaanTerbaru->type }}</p>
                                                </td>
                                                <td>
                                                    <p class="text-md font-weight-normal  mb-0">
                                                        {{ $permintaanTerbaru->created_at->format('d M Y') }}</p>
                                                </td>
                                                <td class="text-center">
                                                    <a href="/dashboard-dosen/validasi/{{ $permintaanTerbaru->id }}"
                                                        class="btn btn-outline-info px-2 py-1" title="Lihat">
                                                        <i class="material-icons">visibility</i>
                                                    </a>

                                                    <a href="javascript:void(0)"
                                                        onclick="handleValidation({{ $permintaanTerbaru->id }}, 'approve')"
                                                        class="btn btn-outline-success px-2 py-1" title="Setujui">
                                                        <i class="material-icons">check</i>
                                                    </a>

                                                    <a href="javascript:void(0)"
                                                        onclick="handleValidation({{ $permintaanTerbaru->id }}, 'reject')"
                                                        class="btn btn-outline-danger px-2 py-1" title="Tolak">
                                                        <i class="material-icons">close</i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                @endif
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 mt-xl-0 mt-4">
                <div class="card">
                    <div class="card-header">
                        <h5>Jadwal Sidang Bulan Ini</h5>
                        <hr class="dark horizontal my-0" />
                    </div>
                    <div class="card-body mt-0 pt-0">
                        <div class="table-responsive">
                            <table class="table align-items-center mb-0">
                                @if ($sidangTerdekats->isEmpty())
                                    <p class="text-center font-weight-bold">Tidak ada jadwal sidang bulan ini.</p>
                                @else
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
                                                    <p class="text-xs font-weight-normal mb-0">
                                                        {{ $sidangTerdekat->skripsi->tanggal_sidang }}</p>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                @endif
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-xl-4 mt-4">
        <div class="col-lg-6">
            <div class="card  border-0 shadow-lg">
                <div class="card-body">
                    <!-- Profile Header -->
                    <div class="row align-items-center mb-4 pb-3 border-bottom">
                        <div class="col-auto">
                            <div class="avatar avatar-xl position-relative">
                                <img src="{{ $dosen->foto_dosen }}" alt="profile_image"
                                    class="w-100 border-radius-lg shadow-sm object-fit-cover"
                                    style="width: 80px; height: 80px;">
                            </div>
                        </div>
                        <div class="col">
                            <h4 class="mb-1 text-dark font-weight-bold">{{ $dosen->nama }}</h4>
                            <p class="mb-0 text-muted text-sm">{{ $dosen->nip }}</p>
                        </div>
                    </div>

                    <!-- Profile Information -->
                    <div class="row g-4">
                        <div class="col-md-6">
                            <h6 class="text-uppercase text-secondary font-weight-bold text-xs mb-3">Informasi Kontak</h6>
                            <div class="d-flex mb-3">
                                <span class="text-dark font-weight-bold text-sm me-2">Kode Wali:</span>
                                <span class="text-muted text-sm">{{ $dosen->kode_wali }}</span>
                            </div>
                            <div class="d-flex mb-3">
                                <span class="text-dark font-weight-bold text-sm me-2">No HP:</span>
                                <span class="text-muted text-sm">{{ $dosen->no_hp }}</span>
                            </div>
                            <div class="d-flex">
                                <span class="text-dark font-weight-bold text-sm me-2">Email:</span>
                                <a href="mailto:{{ $dosen->email }}"
                                    class="text-primary text-sm text-decoration-none">{{ $dosen->email }}</a>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-uppercase text-secondary font-weight-bold text-xs mb-3">Informasi Akademik</h6>
                            <div class="d-flex mb-3">
                                <span class="text-dark font-weight-bold text-sm me-2">Departemen:</span>
                                <span class="text-muted text-sm">Informatika</span>
                            </div>
                            <div class="d-flex">
                                <span class="text-dark font-weight-bold text-sm me-2">Fakultas:</span>
                                <span class="text-muted text-sm">Sains dan Matematika</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 mt-xl-0 mt-4">
            <div class="card">
                <div class="card-body">
                    <h5>Perlu Ditegur (Absen Bimbingan) Skripsi</h5>
                    <div class="table-responsive">
                        <table class="table align-items-center mb-0" id="validationRequestsTable">
                            @if ($mhsSkripsiMangkraks->isEmpty())
                                <p class="text-center font-weight-bold">Tidak ada mahasiswa kritis.</p>
                            @else
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-md font-weight-bolder opacity-7 "
                                            style="width: auto; white-space: nowrap;">
                                            Nama
                                        </th>
                                        <th
                                            class="text-uppercase text-secondary text-center text-md font-weight-bolder opacity-7 ">
                                            Terakhir<br> Bimbingan</th>
                                        <th
                                            class="text-uppercase text-secondary text-center text-md font-weight-bolder opacity-7 ">
                                            Status</th>
                                        <th
                                            class="text-uppercase text-secondary text-center text-md font-weight-bolder opacity-7 ">
                                            Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($mhsSkripsiMangkraks as $mhsSkripsiMangkrak)
                                        <tr>
                                            <td style="width: auto; white-space: nowrap;">
                                                <div class="px-0">
                                                    <div class="my-auto ms-2">
                                                        <h6 class="mb-0 text-md">
                                                            {{ $mhsSkripsiMangkrak->nama }}
                                                        </h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <p class="text-md font-weight-normal  mb-0">
                                                    {{ $mhsSkripsiMangkrak->hari_mangkrak }} Hari</p>
                                            </td>
                                            <td class="text-center">
                                                <p
                                                    class="text-md text-{{ $mhsSkripsiMangkrak->warna_status }} font-weight-normal  mb-0">
                                                    {{ $mhsSkripsiMangkrak->status_mangkrak == 'Kritis' ? '🔴' : '🟡' }}{{ $mhsSkripsiMangkrak->status_mangkrak }}
                                                </p>
                                            </td>
                                            <td class="text-center">
                                                <a href="/dashboard-dosen/validasi/"
                                                    class="btn btn-outline-success px-2 py-1" title="Hubungi Mahasiswa">
                                                    <i class="material-icons">call</i>
                                                </a>

                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            @endif
                        </table>
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

        $(document).ready(function() {
            $('#validationRequestsTable').DataTable({
                paging: false,
                searching: false,
                scrollY: '400px',
                scrollCollapse: true,
                info: false
            });
        });
    </script>
@endsection
