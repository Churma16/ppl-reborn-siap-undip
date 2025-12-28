@extends('dashboard-admin.layouts.main')

@section('styles')
    <style>
        /* Target the DataTable body rows */
        table.dataTable tbody td {
            border: 1px solid #e0e0e0;
            border-left: none;
            border-right: none;
        }

        .dataTables_filter {
            display: none;
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
                            Data Semester
                        </h6>

                        <button type="button" class="btn btn-sm btn-white text-dark me-3 mb-0 d-flex align-items-center"
                            data-bs-toggle="modal" data-bs-target="#modalTambah">
                            <i class="material-icons text-sm me-1">add</i> Tambah Semester
                        </button>

                    </div>
                </div>

                <div class="card-body px-0 pb-4">
                    <div class="row px-4 pb-4"></div>

                    <div class="table-responsive p-0 mx-4">
                        <table class="table align-items-center mb-0" id="semesterTable">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">No</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Kode
                                        Semester</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Nama Semester</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Status</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Tgl Mulai</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Tgl Selesai</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($semesters as $semester)
                                    <tr>
                                        <td>
                                            <div class="d-flex px-2 py-1">
                                                <span
                                                    class="text-secondary text-xs font-weight-bold ps-2">{{ $loop->iteration }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0 ps-3">{{ $semester->kode_semester }}
                                            </p>
                                        </td>
                                        <td>
                                            <h6 class="mb-0 text-sm">{{ $semester->nama_semester }}</h6>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <span class="badge badge-sm bg-gradient-{{ $semester->is_active->color() }}">
                                                {{ $semester->is_active->label() }}
                                            </span>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span
                                                class="text-secondary text-xs font-weight-bold">{{ $semester->tanggal_mulai }}</span>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span
                                                class="text-secondary text-xs font-weight-bold">{{ $semester->tanggal_selesai }}</span>
                                        </td>
                                        <td class="align-middle text-center">
                                            <div class="d-flex align-items-center justify-content-center">

                                                {{-- BUTTON EDIT --}}
                                                {{-- Target matches the unique ID created below --}}
                                                <button type="button" class="border-0 bg-transparent p-0 me-3"
                                                    data-bs-toggle="modal" data-bs-target="#modalEdit{{ $semester->id }}">
                                                    <i class="material-icons text-warning text-gradient">edit</i>
                                                </button>

                                                {{-- BUTTON DELETE --}}
                                                <form action="{{ url('/dashboard-admin/semester/' . $semester->id) }}"
                                                    method="POST" class="d-inline form-delete">
                                                    @csrf
                                                    @method('delete')
                                                    <button type="button"
                                                        class="border-0 bg-transparent p-0 mb-0 btn-delete">
                                                        <i class="material-icons text-danger text-gradient">delete</i>
                                                    </button>
                                                </form>

                                            </div>

                                            {{-- =========================== --}}
                                            {{-- MODAL EDIT (Inside Loop) --}}
                                            {{-- =========================== --}}
                                            <div class="modal fade" id="modalEdit{{ $semester->id }}" tabindex="-1"
                                                aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title font-weight-normal">Edit Semester</h5>
                                                            <button type="button" class="btn-close text-dark"
                                                                data-bs-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <form
                                                            action="{{ url('/dashboard-admin/semester/' . $semester->id) }}"
                                                            method="POST" class="text-start">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="modal-body">

                                                                {{-- Nama Semester --}}
                                                                {{-- Added 'is-filled' class so label doesn't overlap value --}}
                                                                <div class="input-group input-group-outline mb-3 is-filled">
                                                                    <label class="form-label">Nama Semester</label>
                                                                    <input type="text" name="nama_semester"
                                                                        class="form-control"
                                                                        value="{{ $semester->nama_semester }}" required>
                                                                </div>

                                                                {{-- Status Semester --}}
                                                                <div class="input-group input-group-outline mb-3 is-filled">
                                                                    <select name="status_semester" class="form-control"
                                                                        required style="appearance: auto;">
                                                                        {{-- Logic to select the correct option --}}
                                                                        <option value="1"
                                                                            {{ $semester->is_active ? 'selected' : '' }}>
                                                                            Aktif</option>
                                                                        <option value="0"
                                                                            {{ !$semester->is_active ? 'selected' : '' }}>
                                                                            Tidak Aktif</option>
                                                                    </select>
                                                                </div>

                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        {{-- Tanggal Mulai --}}
                                                                        <div
                                                                            class="input-group input-group-outline mb-3 is-filled">
                                                                            <label class="form-label">Tanggal Mulai</label>
                                                                            <input type="date" name="tanggal_mulai"
                                                                                class="form-control"
                                                                                value="{{ $semester->tanggal_mulai }}"
                                                                                required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        {{-- Tanggal Selesai --}}
                                                                        <div
                                                                            class="input-group input-group-outline mb-3 is-filled">
                                                                            <label class="form-label">Tanggal
                                                                                Selesai</label>
                                                                            <input type="date" name="tanggal_selesai"
                                                                                class="form-control"
                                                                                value="{{ $semester->tanggal_selesai }}"
                                                                                required>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn bg-gradient-secondary"
                                                                    data-bs-dismiss="modal">Batal</button>
                                                                <button type="submit"
                                                                    class="btn bg-gradient-info">Update</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- END MODAL EDIT --}}

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

    {{-- MODAL TAMBAH (CREATE) --}}
    <div class="modal fade" id="modalTambah" tabindex="-1" aria-labelledby="modalTambahLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-normal" id="modalTambahLabel">Tambah Semester Baru</h5>
                    <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ url('/dashboard-admin/semester') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div
                            class="input-group input-group-outline mb-3 @if (old('nama_semester')) is-filled @endif @error('nama_semester') is-invalid @enderror">
                            <label class="form-label">Nama Semester</label>
                            <input type="text" name="nama_semester" class="form-control"
                                value="{{ old('nama_semester') }}" required>
                            @error('nama_semester')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- Status Semester --}}
                        <div class="input-group input-group-outline mb-3 @error('is_active') is-invalid @enderror">
                            <select name="is_active" class="form-control" required style="appearance: auto;">
                                <option value="" disabled selected>Pilih Status Semester</option>
                                <option value="1" {{ old('is_active') == '1' ? 'selected' : '' }}>Aktif</option>
                                <option value="0" {{ old('is_active') == '0' ? 'selected' : '' }}>Tidak Aktif
                                </option>
                            </select>
                            @error('is_active')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                {{-- Tanggal Mulai --}}
                                {{-- Added logic: if old value exists, add 'is-filled' class --}}
                                <div
                                    class="input-group input-group-outline mb-3 @if (old('tanggal_mulai')) is-filled @endif @error('tanggal_mulai') is-invalid @enderror">
                                    <label class="form-label">Tanggal Mulai</label>
                                    <input type="date" name="tanggal_mulai" class="form-control"
                                        value="{{ old('tanggal_mulai') }}" required>
                                    @error('tanggal_mulai')
                                        <div class="invalid-feedback d-block">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                {{-- Tanggal Selesai --}}
                                <div
                                    class="input-group input-group-outline mb-3 @if (old('tanggal_selesai')) is-filled @endif @error('tanggal_selesai') is-invalid @enderror">
                                    <label class="form-label">Tanggal Selesai</label>
                                    <input type="date" name="tanggal_selesai" class="form-control"
                                        value="{{ old('tanggal_selesai') }}" required>
                                    @error('tanggal_selesai')
                                        <div class="invalid-feedback d-block">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn bg-gradient-info">Simpan</button>
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
            var dataTable = $('#semesterTable').DataTable({
                columnDefs: [{
                        targets: [0, 6],
                        orderable: false
                    },
                    {
                        className: "text-center",
                        targets: [3, 4, 5, 6]
                    }
                ],
                language: {
                    paginate: {
                        previous: "<",
                        next: ">"
                    }
                }
            });


            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: "{{ session('success') }}",
                    showConfirmButton: false,
                    timer: 1500
                });
            @endif

            // 2. Cek Pesan Error Custom (DARI CONTROLLER)
            @if (session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: "{{ session('error') }}",
                });
            @endif

            // 3. Cek Error Validasi Form (Jika modal harus dibuka kembali)
            @if ($errors->any())
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: 'Mohon periksa kembali inputan anda.',
                });

                // Opsional: Buka modal lagi jika error datang dari form tambah
                // var myModal = new bootstrap.Modal(document.getElementById('modalTambah'), {
                //     keyboard: false
                // });
                // myModal.show();
            @endif

            // 4. Konfirmasi Hapus
            $('.btn-delete').click(function(e) {
                e.preventDefault();
                var form = $(this).closest('form');

                Swal.fire({
                    title: 'Apakah anda yakin?',
                    text: "Data yang dihapus tidak dapat dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                })
            });
        });
    </script>
@endsection
