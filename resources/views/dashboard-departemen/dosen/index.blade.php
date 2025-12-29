@extends('dashboard-departemen.layouts.main')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card my-4">

                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">
                            {{ $title }}
                        </h6>
                    </div>
                </div>

                <div class="card-body px-0 pb-4">

                    {{-- Search Filters --}}
                    <div class="row px-4 py-3">
                        <div class="col-md-12 mb-2">
                            <h6 class="text-sm font-weight-bold text-secondary">Cari Berdasarkan</h6>
                        </div>
                        <div class="col-md-4">
                            <div class="input-group input-group-outline mb-2">
                                <label class="form-label">NIM...</label>
                                <input type="text" id="nipSearch" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="input-group input-group-outline mb-2">
                                <label class="form-label">Nama...</label>
                                <input type="text" id="namaSearch" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="input-group input-group-outline mb-2">
                                <label class="form-label">Kode Wali...</label>
                                <input type="text" id="kodeWaliSearch" class="form-control">
                            </div>
                        </div>
                    </div>

                    {{-- Table Data --}}
                    <div class="table-responsive p-0 mx-4">
                        <table class="table align-items-center mb-0" id="mahasiswaTable">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-4">No
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Foto
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">NIP</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Nama</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Kode Wali</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Jumlah<br>Anak Wali</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Kontak</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- LOOP 1: HANYA UNTUK BARIS TABEL --}}
                                @foreach ($dosens as $dosen)
                                    <tr>
                                        <td class="align-middle text-center">
                                            <span
                                                class="text-secondary text-xs font-weight-bold">{{ $loop->iteration }}</span>
                                        </td>
                                        <td class="align-middle">
                                            <div class="d-flex px-2 py-1">
                                                <img src="{{ $dosen->foto_dosen }}"
                                                    class="avatar avatar-sm border-radius-lg" alt="foto">
                                            </div>
                                        </td>
                                        <td class="align-middle">
                                            <span class="text-secondary text-xs font-weight-bold">{{ $dosen->nip }}</span>
                                        </td>
                                        <td class="align-middle">
                                            <h6 class="mb-0 text-sm">{{ Str::limit($dosen->nama, 30) }}</h6>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span
                                                class="text-secondary text-xs font-weight-bold">{{ $dosen->kode_wali }}</span>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span
                                                class="text-secondary text-xs font-weight-bold">{{ $dosen->mahasiswa_count }}</span>
                                        </td>
                                        <td class="align-middle">
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">{{ $dosen->email }}</h6>
                                                <p class="text-xs text-secondary mb-0">{{ $dosen->no_hp }}</p>
                                            </div>
                                        </td>
                                        <td class="align-middle text-center">
                                            <a href="#" class="text-secondary font-weight-bold text-xs"
                                                data-bs-toggle="modal" data-bs-target="#modalAnakWali{{ $dosen->nip }}"
                                                data-toggle="tooltip" title="Lihat Detail Anak Wali">
                                                <i class="material-icons text-info text-gradient">visibility</i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div> {{-- End Table Responsive --}}

                </div>
            </div>
        </div>
    </div>

    {{-- LOOP 2: MODALS (DI LUAR TABEL) --}}
    {{-- LOOP 2: MODALS (BEAUTIFIED) --}}
    @foreach ($dosens as $dosen)
        <div class="modal fade" id="modalAnakWali{{ $dosen->nip }}" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">

                    {{-- 1. HEADER MODAL DENGAN GRADASI --}}
                    <div class="modal-header bg-gradient-dark p-3">
                        <div class="d-flex align-items-center">
                            <i class="material-icons text-white me-2">school</i>
                            <h5 class="modal-title font-weight-normal text-white" id="modalLabel{{ $dosen->nip }}">
                                Perwalian: <span class="font-weight-bold">{{ $dosen->nama }}</span>
                            </h5>
                        </div>
                        <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close"
                            style="filter: brightness(0) invert(1);">
                        </button>
                    </div>

                    <div class="modal-body p-0">
                        <div class="table-responsive">
                            <table class="table align-items-center mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        {{-- 2. TYPOGRAPHY MATERIAL DESIGN --}}
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-4">
                                            Mahasiswa</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            NIM</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Angkatan</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($dosen->mahasiswa as $mhs)
                                        <tr>
                                            <td class="align-middle ps-4">
                                                <div class="d-flex px-2 py-1">
                                                    {{-- 3. AVATAR PLACEHOLDER (Agar lebih hidup) --}}
                                                    <div>
                                                        <img src="{{ $mhs->foto_mahasiswa }}"
                                                            class="avatar avatar-sm me-3 border-radius-lg" alt="user1">
                                                    </div>
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">{{ $mhs->nama }}</h6>
                                                        <p class="text-xs text-secondary mb-0">
                                                            {{ $mhs->email ?? 'email@student.undip.ac.id' }}</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="align-middle">
                                                <span
                                                    class="text-secondary text-xs font-weight-bold">{{ $mhs->nim }}</span>
                                            </td>
                                            <td class="align-middle text-center">
                                                <span
                                                    class="text-secondary text-xs font-weight-bold">{{ $mhs->angkatan }}</span>
                                            </td>
                                            <td class="align-middle text-center">
                                                {{-- 4. BADGE STATUS GRADIENT --}}
                                                @php
                                                    $statusClass =
                                                        $mhs->status_akademik == 'Aktif'
                                                            ? 'bg-gradient-success'
                                                            : ($mhs->status_akademik == 'Tidak Aktif'
                                                                ? 'bg-gradient-danger'
                                                                : 'bg-gradient-secondary');
                                                @endphp
                                                <span class="badge badge-sm {{ $statusClass }}">
                                                    {{ $mhs->status_akademik }}
                                                </span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center py-5">
                                                <div class="d-flex flex-column align-items-center justify-content-center">
                                                    <i class="material-icons text-secondary opacity-5"
                                                        style="font-size: 3rem;">person_off</i>
                                                    <h6 class="text-secondary font-weight-normal mt-2">Belum ada mahasiswa
                                                        perwalian.</h6>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-link text-secondary mb-0"
                            data-bs-dismiss="modal">Tutup</button>
                        <a href="/dashboard-departemen/cetak-perwalian/{{ $dosen->nip }}" target="_blank"
                            class="btn bg-gradient-dark mb-0">
                            <i class="material-icons text-sm me-2">print</i> Cetak Laporan
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            if ($('#mahasiswaTable').length > 0) {
                var dataTable = $('#mahasiswaTable').DataTable({
                    autoWidth: false,
                    responsive: true,
                    // Hides default search 'f', keeps length menu 'l'
                    dom: '<"d-flex justify-content-between"l>rtip',
                    columnDefs: [{
                        targets: [1, 7],
                        orderable: false
                    }]
                });

                // Custom Search Logic
                $('#nipSearch').on('keyup', function() {
                    dataTable.column(2).search(this.value).draw();
                });
                $('#namaSearch').on('keyup', function() {
                    dataTable.column(3).search(this.value).draw();
                });
                $('#kodeWaliSearch').on('change', function() {
                    dataTable.column(4).search(this.value).draw();
                });
            }

            // SweetAlert Logic
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: "{{ session('success') }}",
                    showConfirmButton: false,
                    timer: 1500
                });
            @endif

            @if ($errors->any())
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: 'Mohon periksa kembali inputan anda.'
                });
            @endif
        });
    </script>
@endsection
