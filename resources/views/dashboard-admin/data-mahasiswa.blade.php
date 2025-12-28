@extends('dashboard-admin.layouts.main')

@section('styles')
    <style>
        table.dataTable tbody td {
            border: 1px solid #e0e0e0;
            border-left: none;
            border-right: none;
        }

        .dataTables_filter {
            display: none;
        }

        /* Fix Select Option Arrow in Material Dashboard */
        select.form-control {
            -webkit-appearance: none;
            appearance: none;
        }
    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card my-4">

                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div
                        class="bg-gradient-dark shadow-dark border-radius-lg py-3 d-flex justify-content-between align-items-center">

                        <h6 class="text-white text-capitalize ps-3 mb-0">
                            Data Mahasiswa
                        </h6>

                        <button type="button" class="btn btn-sm btn-white text-dark me-3 mb-0 d-flex align-items-center"
                            data-bs-toggle="modal" data-bs-target="#modalTambah">
                            <i class="material-icons text-sm me-1">add</i> Tambah Mahasiswa
                        </button>

                    </div>
                </div>

                <div class="card-body px-0 pb-4">

                    <div class="row px-4 py-3">
                        <div class="col-md-12 mb-2">
                            <h6 class="text-sm font-weight-bold text-secondary">Cari Berdasarkan</h6>
                        </div>

                        <div class="col-md-3">
                            <div class="input-group input-group-outline mb-2">
                                <label class="form-label">NIM...</label>
                                <input type="text" id="nimSearch" class="form-control">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="input-group input-group-outline mb-2">
                                <label class="form-label">Nama...</label>
                                <input type="text" id="namaSearch" class="form-control">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="input-group input-group-outline mb-2">
                                <select id="kodeWaliSearch" class="form-control" style="appearance: auto;">
                                    <option value="" selected>Semua Kode Wali</option>
                                    @foreach ($dosens as $dosen)
                                        <option value="{{ $dosen->kode_wali }}">{{ $dosen->kode_wali }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="input-group input-group-outline mb-2">
                                <label class="form-label">Angkatan...</label>
                                <input type="text" id="angkatanSearch" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive p-0 mx-4">
                        <table class="table align-items-center mb-0" id="mahasiswaTable">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">No</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Foto
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">NIM</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Nama</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Wali</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        IPK</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        SKSk</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Semester</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Status</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Angkatan</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($mahasiswas as $mahasiswa)
                                    <tr>
                                        <td class="align-middle text-center">
                                            <span
                                                class="text-secondary text-xs font-weight-bold">{{ $loop->iteration }}</span>
                                        </td>
                                        <td class="align-middle">
                                            <div class="d-flex px-2 py-1">
                                                <img src="{{ $mahasiswa->foto_mahasiswa }}"
                                                    class="avatar avatar-sm border-radius-lg" alt="foto">
                                            </div>
                                        </td>
                                        <td class="align-middle">
                                            <span
                                                class="text-secondary text-xs font-weight-bold">{{ $mahasiswa->nim }}</span>
                                        </td>
                                        <td class="align-middle">
                                            <h6 class="mb-0 text-sm">{{ Str::limit($mahasiswa->nama, 30) }}</h6>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span
                                                class="text-secondary text-xs font-weight-bold">{{ $mahasiswa->dosen_kode_wali }}</span>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span
                                                class="text-secondary text-xs font-weight-bold">{{ $mahasiswa->jumlah_sks }}</span>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span
                                                class="text-secondary text-xs font-weight-bold">{{ $mahasiswa->ip_kumulatif }}</span>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span
                                                class="text-secondary text-xs font-weight-bold">{{ $mahasiswa->semester_aktif }}</span>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            @if ($mahasiswa->status_aktif)
                                                <span class="badge badge-sm bg-gradient-success">Aktif</span>
                                            @else
                                                <span class="badge badge-sm bg-gradient-danger">Tidak Aktif</span>
                                            @endif
                                        </td>
                                        <td class="align-middle text-center">
                                            <span
                                                class="text-secondary text-xs font-weight-bold">{{ $mahasiswa->angkatan }}</span>
                                        </td>
                                        <td class="align-middle text-center">
                                            <div class="d-flex align-items-center justify-content-center">
                                                <a href="#" class="text-secondary font-weight-bold text-xs me-3">
                                                    <i class="material-icons text-warning text-gradient">edit</i>
                                                </a>
                                                <a href="#" class="text-secondary font-weight-bold text-xs">
                                                    <i class="material-icons text-danger text-gradient">delete</i>
                                                </a>
                                            </div>
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

    {{-- ? MODAL TAMBAH MAHASISWA --}}
    <div class="modal fade" id="modalTambah" tabindex="-1" aria-labelledby="modalTambahLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-normal" id="modalTambahLabel">Tambah Mahasiswa Baru</h5>
                    <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form method="POST" action="{{ url('/dashboard-admin/mahasiswa') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            {{-- KOLOM KIRI --}}
                            <div class="col-lg-6 col-md-12">

                                {{-- NIM --}}
                                <div
                                    class="input-group input-group-outline mb-3 @if (old('nim')) is-filled @endif @error('nim') is-invalid @enderror">
                                    <label class="form-label">Nomor Induk Mahasiswa (NIM)</label>
                                    <input type="text" name="nim" class="form-control"
                                        value="{{ old('nim') }}" required>
                                    @error('nim')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- NAMA --}}
                                <div
                                    class="input-group input-group-outline mb-3 @if (old('nama')) is-filled @endif @error('nama') is-invalid @enderror">
                                    <label class="form-label">Nama Lengkap</label>
                                    <input type="text" name="nama" class="form-control"
                                        value="{{ old('nama') }}" required>
                                    @error('nama')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- EMAIL --}}
                                <div
                                    class="input-group input-group-outline mb-3 @if (old('email')) is-filled @endif @error('email') is-invalid @enderror">
                                    <label class="form-label">Email</label>
                                    <input type="email" name="email" class="form-control"
                                        value="{{ old('email') }}" required>
                                    @error('email')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- KOLOM KANAN --}}
                            <div class="col-lg-6 col-md-12">

                                {{-- ANGKATAN --}}
                                <div
                                    class="input-group input-group-outline mb-3 @if (old('angkatan')) is-filled @endif @error('angkatan') is-invalid @enderror">
                                    <label class="form-label">Angkatan</label>
                                    <input type="number" name="angkatan" class="form-control"
                                        value="{{ old('angkatan') }}" required>
                                    @error('angkatan')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- JALUR MASUK --}}
                                <div
                                    class="input-group input-group-outline mb-3 is-filled @error('jalur_masuk') is-invalid @enderror">
                                    <label class="form-label">Jalur Masuk</label>
                                    <select name="jalur_masuk" class="form-control" required style="appearance: auto;">
                                        <option value="" disabled selected>-- Pilih Jalur Masuk --</option>
                                        <option value="SNMPTN" {{ old('jalur_masuk') == 'SNMPTN' ? 'selected' : '' }}>
                                            SNMPTN</option>
                                        <option value="SBMPTN" {{ old('jalur_masuk') == 'SBMPTN' ? 'selected' : '' }}>
                                            SBMPTN</option>
                                        <option value="Mandiri" {{ old('jalur_masuk') == 'Mandiri' ? 'selected' : '' }}>
                                            Mandiri</option>
                                    </select>
                                    @error('jalur_masuk')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- DOSEN WALI --}}
                                <div
                                    class="input-group input-group-outline mb-3 is-filled @error('dosen_kode_wali') is-invalid @enderror">
                                    <label class="form-label">Dosen Wali</label>
                                    <select name="dosen_kode_wali" class="form-control" required
                                        style="appearance: auto;">
                                        <option value="" disabled selected>-- Pilih Dosen Wali --</option>
                                        @foreach ($dosens as $dosen)
                                            <option value="{{ $dosen->kode_wali }}"
                                                {{ old('dosen_kode_wali') == $dosen->kode_wali ? 'selected' : '' }}>
                                                {{ $dosen->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('dosen_kode_wali')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn bg-gradient-info">Simpan Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            // Initialize DataTable
            var dataTable = $('#mahasiswaTable').DataTable({
                columnDefs: [{
                        targets: [1, 7],
                        orderable: false
                    },
                    {
                        className: "text-center",
                        targets: [0, 4, 5, 6, 7]
                    }
                ]
            });

            // --- LOGIKA PENCARIAN ---
            $('#nimSearch').on('keyup', function() {
                dataTable.column(2).search(this.value).draw();
            });
            $('#namaSearch').on('keyup', function() {
                dataTable.column(3).search(this.value).draw();
            });
            $('#kodeWaliSearch').on('change', function() {
                dataTable.column(4).search(this.value).draw();
            });
            $('#angkatanSearch').on('keyup', function() {
                dataTable.column(6).search(this.value).draw();
            });

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
                    text: 'Mohon periksa kembali inputan anda.',
                });
                var myModal = new bootstrap.Modal(document.getElementById('modalTambah'), {
                    keyboard: false
                });
                myModal.show();
            @endif
        });
    </script>
@endsection
