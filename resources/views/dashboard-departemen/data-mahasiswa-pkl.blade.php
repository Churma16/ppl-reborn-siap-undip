{{-- @dd($mahasiswas) --}}
@extends('dashboard-departemen.layouts.main')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card my-4">

                {{-- CARD HEADER --}}
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">
                            Data Mahasiswa PKL
                        </h6>
                    </div>
                </div>

                {{-- FILTER ANGKATAN (Uncomment if needed) --}}
                {{--
                <div class="card-body px-0 pb-2 ms-3" style="overflow-x: auto;" id="scrollContainer">
                    <div class="d-flex flex-row">
                        @foreach ($angkatans as $angkatan)
                            <div class="mx-2">
                                <button type="button" class="btn btn-secondary btn-sm angkatanSelector"
                                    data-angkatan="{{ $angkatan->angkatan }}">
                                    {{ $angkatan->angkatan }}
                                </button>
                            </div>
                        @endforeach
                    </div>
                </div>
                --}}

                <div class="card-body px-0 pb-4">

                    {{-- BAGIAN FILTER & PENCARIAN (TAMBAHAN) --}}
                    <div class="d-flex justify-content-between mx-3 mb-3">
                        <div class="d-flex">
                            {{-- Filter Status --}}
                            <select class="form-select form-select-sm me-2" id="statusLulus" style="width: 150px;">
                                <option value="">Semua Status</option>
                                <option value="Lulus">Lulus</option>
                                <option value="Belum Lulus">Belum Lulus</option>
                            </select>
                            {{-- Tombol Export --}}
                            <button class="btn btn-sm btn-outline-success mb-0" data-bs-toggle="modal"
                                data-bs-target="#modalExport">Export Excel</button>
                        </div>

                        {{-- Search Bar --}}
                        <div class="input-group input-group-sm input-group-outline" style="width: 250px;">
                            <label class="form-label">Cari Nama / NIM...</label>
                            <input type="text" id="namaNimSearch" class="form-control">
                        </div>
                    </div>

                    <div class="table-responsive p-0 mx-4">
                        <table class="table align-items-center mb-0" id="pklTable">
                            <thead>
                                <tr>
                                    {{-- Hapus kolom Foto jika ingin lebih ringkas --}}
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-4">
                                        Mahasiswa</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Angkatan</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Instansi</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Terakhir<br>Bimbingan</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Periode</th> {{-- Digabung --}}
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Status</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Aksi</th> {{-- Tambahan --}}
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($mahasiswas as $mahasiswa)
                                    <tr>
                                        <td>
                                            <div class="d-inline-flex px-3 py-1 align-items-center">
                                                <div>
                                                    <img src="{{ $mahasiswa->foto_mahasiswa }}"
                                                        class="avatar avatar-sm me-3 border-radius-lg" alt="foto">
                                                </div>
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm">{{ $mahasiswa->nama }}</h6>
                                                    <p class="text-xs text-secondary mb-0">{{ $mahasiswa->nim }}</p>
                                                </div>
                                            </div>
                                        </td>

                                        <td class="align-middle text-center">
                                            <span
                                                class="text-secondary text-xs font-weight-bold">{{ $mahasiswa->angkatan }}</span>
                                        </td>

                                        <td>
                                            <p class="text-xs font-weight-bold mb-0 text-wrap" style="max-width: 150px;">
                                                {{ $mahasiswa->pklTerakhir->nama_perusahaan ?? '-' }}
                                            </p>
                                        </td>

                                        <td class="align-middle ">
                                            <span
                                                class="text-secondary text-xs font-weight-bold">{{ $mahasiswa->pklTerakhir->created_at->format('d M Y') }}</span>
                                        </td>

                                        <td class="align-middle text-center">
                                            @if ($mahasiswa->pklTerakhir)
                                                <span class="text-secondary text-xs font-weight-bold d-block">
                                                    {{ $mahasiswa->pklTerakhir->tanggal_mulai_formatted }}
                                                </span>
                                                <span class="text-secondary text-xxs">s.d.</span>
                                                <span class="text-secondary text-xs font-weight-bold d-block">
                                                    {{ $mahasiswa->pklTerakhir->tanggal_selesai_formatted ?? 'Belum Ditentukan' }}
                                                </span>
                                            @else
                                                <span class="text-xs">-</span>
                                            @endif
                                        </td>

                                        <td class="align-middle text-center text-sm">
                                            @if ($mahasiswa->pklTerakhir == null)
                                                <span class="badge badge-sm bg-gradient-secondary">Belum PKL</span>
                                            @elseif ($mahasiswa->pklTerakhir->status_lulus == 'Lulus')
                                                <span class="badge badge-sm bg-gradient-success">Lulus</span>
                                            @else
                                                <span
                                                    class="badge badge-sm bg-gradient-warning">{{ $mahasiswa->pklTerakhir->status_lulus }}</span>
                                            @endif
                                        </td>

                                        {{-- KOLOM AKSI (BUTTONS) --}}
                                        <td class="align-middle text-center">
                                            {{-- Tombol Download Laporan --}}
                                            @if ($mahasiswa->pklTerakhir && $mahasiswa->pklTerakhir->file_pkl)
                                                <a href="{{ asset('storage/' . $mahasiswa->pklTerakhir->file_pkl) }}"
                                                    class="btn btn-link text-dark px-2 mb-0" data-bs-toggle="tooltip"
                                                    title="Unduh Laporan">
                                                    <i class="material-icons text-sm">download</i>
                                                </a>
                                            @endif

                                            {{-- Tombol Detail (Modal Trigger) --}}
                                            <a href="javascript:;" class="btn btn-link text-info px-2 mb-0"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modalDetailProgress{{ $mahasiswa->nim }}"
                                                title="Lihat Detail Progress">
                                                <i class="material-icons text-sm">visibility</i>
                                            </a>
                                        </td>
                                    </tr>

                                    {{-- ? MODAL DETAIL PROGRESS  --}}
                                    <div class="modal fade" id="modalDetailProgress{{ $mahasiswa->nim }}" tabindex="-1"
                                        aria-labelledby="modalDetailLabel" aria-hidden="true" style="z-index: 1050;">
                                        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                                            <div class="modal-content">

                                                <div
                                                    class="modal-header bg-gradient-dark d-flex justify-content-between align-items-center p-3">
                                                    <h6 class="modal-title text-white m-0" id="modalDetailLabel">Detail
                                                        Progress PKL</h6>
                                                    <button type="button" class="btn-close text-white"
                                                        data-bs-dismiss="modal" aria-label="Close"
                                                        style="color: white !important;">
                                                    </button>
                                                </div>

                                                <div class="modal-body p-4">

                                                    <div class="card card-plain shadow-none border mb-4">
                                                        <div class="card-body p-3 d-flex align-items-center">
                                                            <div class="position-relative me-3">
                                                                <div
                                                                    class="avatar avatar-lg rounded-circleshadow-dark-sm d-flex align-items-center justify-content-center">
                                                                    <img src="{{ $mahasiswa->foto_mahasiswa }}"
                                                                        alt="foto">
                                                                </div>
                                                            </div>

                                                            <div class="d-flex flex-column justify-content-center">
                                                                <h6 class="mb-1 text-dark font-weight-bold">
                                                                    {{ $mahasiswa->nama }}
                                                                </h6>
                                                                <p class="text-xs text-secondary mb-0">NIM:
                                                                    {{ $mahasiswa->nim }} •
                                                                    Angkatan {{ $mahasiswa->angkatan }}</p>
                                                                <p class="text-xs text-secondary mb-0 font-weight-bold text-uppercase mt-1"
                                                                    style="color: #101E46;">
                                                                    <i class="material-icons text-xs me-1 position-relative"
                                                                        style="top: 1px;">business</i>
                                                                    {{ $mahasiswa->pklTerakhir->nama_perusahaan }}
                                                                </p>
                                                            </div>

                                                            <div class="ms-auto text-end d-none d-md-block">
                                                                <span class="badge bg-gradient-success mb-1">Status:
                                                                    {{ $mahasiswa->pklTerakhir->status_lulus }}</span>
                                                                <p class="text-xxs text-secondary mb-0">
                                                                    Periode:{{ $mahasiswa->pklTerakhir->tanggal_mulai_formatted }}
                                                                    -{{ $mahasiswa->pklTerakhir->tanggal_selesai_formatted ?? 'TBA' }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <h6
                                                        class="text-uppercase text-body text-xs font-weight-bolder mb-3 ps-2">
                                                        Riwayat Progress</h6>

                                                    <div class="timeline timeline-one-side" style="position: relative;">
                                                        @foreach ($mahasiswa->pkl as $pkl)
                                                            <div class="timeline-block mb-3">
                                                                <span class="timeline-step">
                                                                    <i
                                                                        class="material-icons text-{{ $pkl->status_konfirmasi->color() }} text-gradient">{{ $pkl->status_konfirmasi->icon() }}</i>
                                                                </span>
                                                                <div class="timeline-content" style="max-width: 100%;">
                                                                    <div class="d-flex justify-content-between pt-1 mb-2">
                                                                        <span
                                                                            class="text-dark text-sm font-weight-bold">Progress
                                                                            Ke-{{ $pkl->progress_ke }}</span>
                                                                        <span
                                                                            class="badge badge-sm bg-gradient-{{ $pkl->status_konfirmasi->color() }}">{{ $pkl->status_konfirmasi->value }}</span>
                                                                    </div>

                                                                    <div class="p-3 border rounded bg-gray-100">
                                                                        <p class="text-sm text-secondary mb-2">
                                                                            {{ $pkl->rincian_progress ?? '(Tidak Ada Rincian)' }}
                                                                        </p>
                                                                        <div class="d-flex align-items-center mt-2">
                                                                            <small
                                                                                class="text-secondary font-weight-bold me-3">
                                                                                <i
                                                                                    class="material-icons text-xs me-1">event</i>
                                                                                {{ $pkl->created_at->format('d M Y H:i') }}
                                                                            </small>
                                                                            <a href="{{ $pkl->file_pkl }}"
                                                                                class="btn btn-xs btn-outline-dark mb-0 py-1 px-2">
                                                                                <i
                                                                                    class="material-icons text-xxs me-1">description</i>
                                                                                File
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                                <div class="modal-footer justify-content-end border-top">
                                                    <button type="button" class="btn btn-light mb-0"
                                                        data-bs-dismiss="modal">Tutup</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
    {{-- ? MODAL EXPORT EXCEL --}}
    <div class="modal fade" id="modalExport" tabindex="-1" aria-labelledby="modalExportLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-gradient-dark">
                    <h6 class="modal-title text-white" id="modalExportLabel">Export Data Mahasiswa PKL</h6>
                    <button type="button" class="btn-close text-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="text-sm text-secondary mb-4">Silakan pilih filter data yang ingin diexport:</p>

                    <form action="/dashboard-departemen/pkl/export" method="POST" id="exportFilteredForm"
                        class="row g-3">
                        @csrf

                        <div class="col-md-4">
                            <div class="input-group input-group-outline is-filled">
                                <label class="form-label">Dosen Wali</label>
                                <select name="dosen_kode_wali" class="form-control" style="appearance: auto;">
                                    <option value="" selected>Semua</option>
                                    @foreach ($dosens as $dosen)
                                        <option value="{{ $dosen->kode_wali }}">{{ $dosen->kode_wali }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="input-group input-group-outline is-filled">
                                <label class="form-label">Angkatan</label>
                                <select name="angkatan" class="form-control" style="appearance: auto;">
                                    <option value="" selected>Semua</option>
                                    @foreach ($angkatans as $angkatan)
                                        <option value="{{ $angkatan }}">{{ $angkatan }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="input-group input-group-outline is-filled">
                                <label class="form-label">Status</label>
                                <select name="status_lulus" class="form-control" style="appearance: auto;">
                                    <option value="" selected>Semua</option>
                                    <option value="Lulus">Lulus</option>
                                    <option value="Belum Lulus">Belum Lulus</option>
                                </select>
                            </div>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="col-12 mt-4">
                            <div class="d-flex gap-2">
                                {{-- Button: Export Filtered --}}
                                <button type="submit" class="btn btn-info w-100 mb-0">
                                    <i class="material-icons text-sm me-2">filter_alt</i>
                                    Export Terfilter
                                </button>
                                <a href="pkl/export"
                                    class="btn btn-outline-success w-100 mb-0">
                                    <i class="material-icons text-sm me-2">download</i>
                                    Export Semua
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Batal</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            var dataTable = $('#pklTable').DataTable({
                autoWidth: false,
                responsive: true,
                "dom": 'rtp',
                columnDefs: [{
                        targets: [6],
                        orderable: false
                    },
                    //     {
                    //         className: "text-center",
                    //         targets: [0, 4, 5, 6, 7, 8, 9, 10]
                    // }
                ]
            });


            $('#namaNimSearch').on('keyup', function() {
                dataTable.column(0).search(this.value).draw();
            });
            $('#statusLulus').on('change', function() {
                var val = $(this).val();

                // 2. Use Regex for Exact Match
                // ^ = Start of line
                // $ = End of line
                // true = Enable Regex
                // false = Disable Smart Search (important!)
                dataTable.column(5).search(val ? '^' + val + '$' : '', true, false).draw();
            });
            // $('#namaSearch').on('keyup', function() {
            //     dataTable.column(3).search(this.value).draw();
            // });
            // $('#kodeWaliSearch').on('change', function() {
            //     dataTable.column(4).search(this.value).draw();
            // });
            // $('#angkatanSearch').on('keyup', function() {
            //     dataTable.column(9).search(this.value).draw();
            // });
        });
    </script>
@endsection
