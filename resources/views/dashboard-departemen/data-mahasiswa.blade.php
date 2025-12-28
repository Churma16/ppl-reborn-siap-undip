@extends('dashboard-departemen.layouts.main')

@section('styles')
    <style>
    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card my-4">

                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">
                            Data Mahasiswa
                        </h6>
                    </div>
                </div>

                <div class="card-body px-0 pb-4">

                    <div class="row px-4 py-3">
                        <div class="col-md-12 mb-2">
                            <h6 class="text-sm font-weight-bold text-secondary">Cari Berdasarkan</h6>
                        </div>
                        <div class="col-md-3">
                            <div class="input-group input-group-outline mb-2"><label class="form-label">NIM...</label><input
                                    type="text" id="nimSearch" class="form-control"></div>
                        </div>
                        <div class="col-md-3">
                            <div class="input-group input-group-outline mb-2"><label
                                    class="form-label">Nama...</label><input type="text" id="namaSearch"
                                    class="form-control"></div>
                        </div>
                        <div class="col-md-3">
                            <div class="input-group input-group-outline mb-2"><select id="kodeWaliSearch"
                                    class="form-control" style="appearance: auto;">
                                    <option value="" selected>Semua Kode Wali</option>
                                    @foreach ($dosens as $dosen)
                                        <option value="{{ $dosen->kode_wali }}">{{ $dosen->kode_wali }}</option>
                                    @endforeach
                                </select></div>
                        </div>
                        <div class="col-md-3">
                            <div class="input-group input-group-outline mb-2"><label
                                    class="form-label">Angkatan...</label><input type="text" id="angkatanSearch"
                                    class="form-control"></div>
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
                                        Smt</th>
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
                                        <td class="align-middle text-center"><span
                                                class="text-secondary text-xs font-weight-bold">{{ $loop->iteration }}</span>
                                        </td>
                                        <td class="align-middle">
                                            <div class="d-flex px-2 py-1"><img src="{{ $mahasiswa->foto_mahasiswa }}"
                                                    class="avatar avatar-sm border-radius-lg" alt="foto"></div>
                                        </td>
                                        <td class="align-middle"><span
                                                class="text-secondary text-xs font-weight-bold">{{ $mahasiswa->nim }}</span>
                                        </td>
                                        <td class="align-middle">
                                            <h6 class="mb-0 text-sm">{{ Str::limit($mahasiswa->nama, 30) }}</h6>
                                        </td>
                                        <td class="align-middle text-center"><span
                                                class="text-secondary text-xs font-weight-bold">{{ $mahasiswa->dosen_kode_wali }}</span>
                                        </td>

                                        <td class="align-middle text-center"><span
                                                class="text-secondary text-xs font-weight-bold">
                                                {{ $mahasiswa->khsTerakhir->ip_kumulatif ?? '0.00' }}</span>
                                        </td>
                                        <td class="align-middle text-center"><span
                                                class="text-secondary text-xs font-weight-bold">
                                                {{ $mahasiswa->khsTerakhir->sks_kumulatif ?? '0.00' }}
                                            </span>
                                        </td>
                                        <td class="align-middle text-center"><span
                                                class="text-secondary text-xs font-weight-bold">{{ $mahasiswa->irsAktif->semester_aktif ?? 'N/A' }}</span>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            @if ($mahasiswa->status_aktif)
                                                <span class="badge badge-sm bg-gradient-success">Aktif</span>
                                            @else
                                                <span class="badge badge-sm bg-gradient-danger">Tidak Aktif</span>
                                            @endif
                                        </td>
                                        <td class="align-middle text-center"><span
                                                class="text-secondary text-xs font-weight-bold">{{ $mahasiswa->angkatan }}</span>
                                        </td>

                                        <td class="align-middle text-center">
                                            <div class="d-flex align-items-center justify-content-center">

                                                <a href="#" class="text-secondary font-weight-bold text-xs me-3"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#modalDetail{{ $mahasiswa->nim }}"
                                                    data-toggle="tooltip" title="Lihat Detail">
                                                    <i class="material-icons text-info text-gradient">visibility</i>
                                                </a>

                                                {{-- <a href="#" class="text-secondary font-weight-bold text-xs me-3"
                                                    data-toggle="tooltip" title="Edit">
                                                    <i class="material-icons text-warning text-gradient">edit</i>
                                                </a>

                                                <a href="#" class="text-secondary font-weight-bold text-xs"
                                                    data-toggle="tooltip" title="Hapus">
                                                    <i class="material-icons text-danger text-gradient">person_off</i>
                                                </a> --}}
                                            </div>
                                            {{-- ? Detail Modal --}}
                                            <div class="modal fade" id="modalDetail{{ $mahasiswa->nim }}" tabindex="-1"
                                                aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title font-weight-normal">Detail Mahasiswa
                                                            </h5>
                                                            <button type="button" class="btn-close text-dark"
                                                                data-bs-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body text-start">

                                                            <div class="row mb-4">
                                                                <div class="col-md-12 text-center">
                                                                    <img src="{{ $mahasiswa->foto_mahasiswa }}"
                                                                        class="avatar avatar-xxl border-radius-lg shadow-sm mb-2"
                                                                        alt="foto profile"
                                                                        style="width: 100px; height: 100px;">
                                                                    <h5 class="mb-0">{{ $mahasiswa->nama }}</h5>
                                                                    <p class="text-sm text-secondary mb-0">
                                                                        {{ $mahasiswa->nim }} |
                                                                        {{ $mahasiswa->jalur_masuk }}</p>
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <h6
                                                                        class="text-uppercase text-body text-xs font-weight-bolder opacity-7 mb-3">
                                                                        Data Akademik</h6>
                                                                    <ul class="list-group">
                                                                        <li class="list-group-item border-0 ps-0 text-sm">
                                                                            <strong class="text-dark">Angkatan:</strong>
                                                                            &nbsp; {{ $mahasiswa->angkatan }}
                                                                        </li>
                                                                        <li class="list-group-item border-0 ps-0 text-sm">
                                                                            <strong class="text-dark">Semester
                                                                                Aktif:</strong> &nbsp; Semester
                                                                            {{ $mahasiswa->irsAktif->semester_aktif ?? 'N/A' }}
                                                                        </li>
                                                                        <li class="list-group-item border-0 ps-0 text-sm">
                                                                            <strong class="text-dark">Dosen Wali:</strong>
                                                                            &nbsp;
                                                                            {{ $mahasiswa->dosen->nama ?? $mahasiswa->dosen_kode_wali }}
                                                                            ({{ $mahasiswa->dosen->kode_wali }})
                                                                        </li>
                                                                        <li class="list-group-item border-0 ps-0 text-sm">
                                                                            <strong class="text-dark">Status
                                                                                Mahasiswa:</strong> &nbsp;
                                                                            @if ($mahasiswa->status_aktif)
                                                                                <span
                                                                                    class="badge bg-gradient-success">Aktif</span>
                                                                            @else
                                                                                <span
                                                                                    class="badge bg-gradient-danger">Tidak
                                                                                    Aktif</span>
                                                                            @endif
                                                                        </li>
                                                                    </ul>
                                                                </div>

                                                                <div class="col-md-6">
                                                                    <h6
                                                                        class="text-uppercase text-body text-xs font-weight-bolder opacity-7 mb-3">
                                                                        Progres Studi</h6>
                                                                    <ul class="list-group">
                                                                        {{-- IPK --}}
                                                                        <li class="list-group-item border-0 ps-0 text-sm">
                                                                            <strong class="text-dark">IP Kumulatif
                                                                                (IPK)
                                                                                :</strong> &nbsp;
                                                                            {{ $mahasiswa->khsTerakhir->ip_kumulatif ?? '0.00' }}
                                                                        </li>

                                                                        {{-- SKSK --}}
                                                                        <li class="list-group-item border-0 ps-0 text-sm">
                                                                            <strong class="text-dark">Total SKS
                                                                                (SKSK):</strong> &nbsp;
                                                                            {{ $mahasiswa->khsTerakhir->sks_kumulatif ?? '0.00' }}

                                                                        </li>

                                                                        {{-- PLACEHOLDER: Status PKL --}}
                                                                        <li class="list-group-item border-0 ps-0 text-sm">
                                                                            <strong class="text-dark">Status PKL:</strong>
                                                                            &nbsp;
                                                                            <span
                                                                                class="badge bg-gradient-{{ $mahasiswa->pklTerakhir->statusColor ?? 'secondary' }}">
                                                                                {{ $mahasiswa->pklTerakhir->status_lulus ?? 'Belum Ambil' }}</span>
                                                                        </li>

                                                                        {{-- PLACEHOLDER: Status Skripsi --}}
                                                                        <li class="list-group-item border-0 ps-0 text-sm">
                                                                            <strong class="text-dark">Status
                                                                                Skripsi:</strong> &nbsp;
                                                                            <span
                                                                                class="badge bg-gradient-{{ $mahasiswa->skripsiTerakhir->statusColor ?? 'secondary' }}">{{ $mahasiswa->skripsiTerakhir->status_skripsi ?? 'Belum Ambil' }}</span>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </div>

                                                            <hr class="horizontal dark my-3">

                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <h6
                                                                        class="text-uppercase text-body text-xs font-weight-bolder opacity-7 mb-3">
                                                                        Kontak & Alamat</h6>
                                                                    <ul class="list-group">
                                                                        {{-- Email dengan tombol Copy --}}
                                                                        <li
                                                                            class="list-group-item border-0 ps-0 text-sm d-flex align-items-center">
                                                                            <strong class="text-dark">Email:</strong>
                                                                            &nbsp;
                                                                            <span
                                                                                id="emailText{{ $mahasiswa->nim }}">{{ $mahasiswa->email }}</span>
                                                                            <button
                                                                                class="btn btn-link text-info p-0 mb-0 ms-2"
                                                                                title="Salin Email"
                                                                                onclick="copyToClipboard('emailText{{ $mahasiswa->nim }}')">
                                                                                <i
                                                                                    class="material-icons text-sm">content_copy</i>
                                                                            </button>
                                                                        </li>

                                                                        {{-- Nomor HP dengan tombol Copy --}}
                                                                        <li
                                                                            class="list-group-item border-0 ps-0 text-sm d-flex align-items-center">
                                                                            <strong class="text-dark">Nomor HP:</strong>
                                                                            &nbsp;
                                                                            @if ($mahasiswa->no_hp)
                                                                                <span
                                                                                    id="phoneText{{ $mahasiswa->nim }}">{{ $mahasiswa->no_hp }}</span>
                                                                                <button
                                                                                    class="btn btn-link text-info p-0 mb-0 ms-2"
                                                                                    title="Salin No HP"
                                                                                    onclick="copyToClipboard('phoneText{{ $mahasiswa->nim }}')">
                                                                                    <i
                                                                                        class="material-icons text-sm">content_copy</i>
                                                                                </button>
                                                                            @else
                                                                                <span
                                                                                    class="text-secondary fst-italic">(Data
                                                                                    nomor HP belum diinput)</span>
                                                                            @endif
                                                                        </li>

                                                                        <li class="list-group-item border-0 ps-0 text-sm">
                                                                            <strong class="text-dark">Alamat Asal:</strong>
                                                                            &nbsp;
                                                                            <span
                                                                                class="text-secondary fst-italic">{{ $mahasiswa->alamat ?? '(Data alamat belum diinput)' }}</span>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </div>

                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn bg-gradient-secondary"
                                                                data-bs-dismiss="modal">Tutup</button>
                                                        </div>
                                                    </div>
                                                </div>
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

    {{-- MODAL TAMBAH MAHASISWA (Using your existing code) --}}
    <div class="modal fade" id="modalTambah" tabindex="-1" aria-labelledby="modalTambahLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-normal" id="modalTambahLabel">Tambah Mahasiswa Baru</h5>
                    <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="{{ url('/dashboard-departemen/mahasiswa') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-6 col-md-12">
                                <div
                                    class="input-group input-group-outline mb-3 @if (old('nim')) is-filled @endif @error('nim') is-invalid @enderror">
                                    <label class="form-label">Nomor Induk Mahasiswa (NIM)</label>
                                    <input type="text" name="nim" class="form-control"
                                        value="{{ old('nim') }}" required>
                                    @error('nim')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div
                                    class="input-group input-group-outline mb-3 @if (old('nama')) is-filled @endif @error('nama') is-invalid @enderror">
                                    <label class="form-label">Nama Lengkap</label>
                                    <input type="text" name="nama" class="form-control"
                                        value="{{ old('nama') }}" required>
                                    @error('nama')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
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
                            <div class="col-lg-6 col-md-12">
                                <div
                                    class="input-group input-group-outline mb-3 @if (old('angkatan')) is-filled @endif @error('angkatan') is-invalid @enderror">
                                    <label class="form-label">Angkatan</label>
                                    <input type="number" name="angkatan" class="form-control"
                                        value="{{ old('angkatan') }}" required>
                                    @error('angkatan')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
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
                                <div
                                    class="input-group input-group-outline mb-3 is-filled @error('dosen_kode_wali') is-invalid @enderror">
                                    <label class="form-label">Dosen Wali</label>
                                    <select name="dosen_kode_wali" class="form-control" required
                                        style="appearance: auto;">
                                        <option value="" disabled selected>-- Pilih Dosen Wali --</option>
                                        @foreach ($dosens as $dosen)
                                            <option value="{{ $dosen->kode_wali }}"
                                                {{ old('dosen_kode_wali') == $dosen->kode_wali ? 'selected' : '' }}>
                                                {{ $dosen->nama }}</option>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            // 1. Check if the table exists
            if ($('#mahasiswaTable').length > 0) {
                var dataTable = $('#mahasiswaTable').DataTable({
                    // This ensures the theme doesn't conflict
                    autoWidth: false,
                    responsive: true,
                    columnDefs: [{
                            targets: [1, 10],
                            orderable: false
                        },
                        {
                            className: "text-center",
                            targets: [0, 4, 5, 6, 7, 8, 9, 10]
                        }
                    ]
                });

                // Search logic (Must be inside the IF because it uses 'dataTable')
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
                    dataTable.column(9).search(this.value).draw();
                });
            }

            // 2. SweetAlert Logic (Runs regardless of table existence)
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
                var myModal = new bootstrap.Modal(document.getElementById('modalTambah'), {
                    keyboard: false
                });
                myModal.show();
            @endif
        });

        // 3. Helper Function (Outside document.ready)
        function copyToClipboard(elementId) {
            // Ambil teks dari elemen
            var copyText = document.getElementById(elementId).innerText;

            // Gunakan Clipboard API
            navigator.clipboard.writeText(copyText).then(function() {
                // Notifikasi sukses menggunakan SweetAlert2 (Toast)
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 2000,
                    timerProgressBar: true,
                });

                Toast.fire({
                    icon: 'success',
                    title: 'Teks berhasil disalin!'
                });
            }).catch(function(err) {
                console.error('Gagal menyalin teks: ', err);
            });
        }
    </script>
@endsection
