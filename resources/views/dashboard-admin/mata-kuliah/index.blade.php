{{-- @dd($mahasiswas) --}}
@extends('dashboard-admin.layouts.main')

@section('styles')
    <style>
        /* Target the DataTable body rows */
        table.dataTable tbody td {
            border: 1px solid #e0e0e0;
            border-left: none;
            border-right: none
                /* Set the border color to gray (#ccc) */
        }
    </style>
    <style>
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
                            {{ $title }}
                        </h6>

                        <button type="button" class="btn btn-sm btn-white text-dark me-3 mb-0 d-flex align-items-center"
                            data-bs-toggle="modal" data-bs-target="#modalTambah">
                            <i class="material-icons text-sm me-1">add</i> Tambah Data
                        </button>

                    </div>
                </div>

                <div class="card-body px-0 pb-4">
                    <div class="table-responsive p-0 mx-4">
                        <table class="table align-items-center mb-0" id="matkulTable">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">No</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Kode
                                        Matkul</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Nama Matakuliah</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        SKS</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Semester</th>

                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($mataKuliah->isEmpty())
                                    <tr>
                                        <td colspan="7" class="text-center">
                                            <span class="text-secondary text-md font-weight-bold">Tidak ada data mata
                                                kuliah.</span>
                                        </td>
                                    </tr>
                                @else
                                    @foreach ($mataKuliah as $matKul)
                                        <tr>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <span
                                                        class="text-secondary text-xs font-weight-bold ps-2">{{ $loop->iteration }}</span>
                                                </div>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0 ps-3">{{ $matKul->kode }}</p>
                                            </td>
                                            <td>
                                                <h6 class="mb-0 text-sm">{{ $matKul->nama }}</h6>
                                                <p class="text-xs text-secondary mb-0">{{ $matKul->sifat }}</p>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <span class="badge badge-sm bg-gradient-info">{{ $matKul->sks }} SKS</span>
                                            </td>
                                            <td class="align-middle text-center">
                                                <span
                                                    class="text-secondary text-xs font-weight-bold">{{ $matKul->semester_ambil }}</span>
                                            </td>

                                            <td class="align-middle text-center">
                                                <button type="button" class="border-0 bg-transparent p-0 me-3"
                                                    data-bs-toggle="modal" data-bs-target="#modalEdit{{ $matKul->id }}">
                                                    <i class="material-icons text-warning text-gradient">edit</i>
                                                </button>
                                                <form action="{{ url('/dashboard-admin/mata-kuliah/' . $matKul->id) }}"
                                                    method="POST" class="d-inline form-delete">
                                                    @csrf
                                                    @method('delete')
                                                    <button type="button"
                                                        class="border-0 bg-transparent p-0 mb-0 btn-delete">
                                                        <i class="material-icons text-danger text-gradient">delete</i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                        {{-- ? MODAL EDIT (Inside Loop) --}}
                                        <div class="modal fade" id="modalEdit{{ $matKul->id }}" tabindex="-1"
                                            aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Edit Mata Kuliah</h5>
                                                        <button type="button" class="btn-close text-dark"
                                                            data-bs-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <form action="{{ url('/dashboard-admin/mata-kuliah/' . $matKul->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="modal-body">
                                                            <div class="input-group input-group-outline mb-3 is-filled">
                                                                <label class="form-label">Kode Mata Kuliah</label>
                                                                <input type="text" name="kode" class="form-control"
                                                                    value="{{ $matKul->kode }}" required>
                                                            </div>
                                                            <div class="input-group input-group-outline mb-3 is-filled">
                                                                <label class="form-label">Nama Matakuliah</label>
                                                                <input type="text" name="nama" class="form-control"
                                                                    value="{{ $matKul->nama }}" required>
                                                            </div>
                                                            <div class="input-group input-group-outline mb-3 is-filled">
                                                                <label class="form-label">Sifat</label>
                                                                <select name="sifat" class="form-control" required
                                                                    style="appearance: auto;">
                                                                    <option value="Wajib"
                                                                        {{ $matKul->sifat == 'Wajib' ? 'selected' : '' }}>
                                                                        Wajib</option>
                                                                    <option value="Pilihan"
                                                                        {{ $matKul->sifat == 'Pilihan' ? 'selected' : '' }}>
                                                                        Pilihan</option>
                                                                </select>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div
                                                                        class="input-group input-group-outline mb-3 is-filled">
                                                                        <label class="form-label">SKS</label>
                                                                        <input type="number" name="sks"
                                                                            class="form-control"
                                                                            value="{{ $matKul->sks }}" min="1"
                                                                            max="6" required>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div
                                                                        class="input-group input-group-outline mb-3 is-filled">
                                                                        <select name="semester_ambil" class="form-control"
                                                                            required style="appearance: auto;">
                                                                            @for ($i = 1; $i <= 8; $i++)
                                                                                <option value="{{ $i }}"
                                                                                    {{ $matKul->semester_ambil == $i ? 'selected' : '' }}>
                                                                                    Semester {{ $i }}</option>
                                                                            @endfor
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn bg-gradient-secondary"
                                                                data-bs-dismiss="modal">Batal</button>
                                                            <button type="submit"
                                                                class="btn bg-gradient-primary">Update</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- ? END MODAL EDIT --}}
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ? Add Modal --}}
    <div class="modal fade" id="modalTambah" tabindex="-1" aria-labelledby="modalTambahLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-normal" id="modalTambahLabel">
                        Tambah Mata Kuliah Baru</h5>
                    <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ url('/dashboard-admin/mata-kuliah') }}" method="POST">
                    @csrf
                    <div class="modal-body">

                        <div class="input-group input-group-outline mb-3">
                            <label class="form-label">Kode MatKul (Misal: TIK-202)</label>
                            <input type="text" name="kode" class="form-control" required>
                        </div>

                        <div class="input-group input-group-outline mb-3">
                            <label class="form-label">Nama Matakuliah</label>
                            <input type="text" name="nama" class="form-control" required>
                        </div>

                        <div class="input-group input-group-outline mb-3">
                            <select name="sifat" class="form-control" required style="appearance: auto;">
                                <option value="" selected disabled>Pilih Sifat Mata Kuliah</option>
                                <option value="Wajib">Wajib</option>
                                <option value="Pilihan">Pilihan</option>
                            </select>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-group input-group-outline mb-3">
                                    <label class="form-label">SKS</label>
                                    <input type="number" name="sks" class="form-control" min="1"
                                        max="6" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-group input-group-outline mb-3">
                                    <select name="semester_ambil" class="form-control" required
                                        style="appearance: auto;">
                                        <option value="" selected disabled>Pilih Semester</option>
                                        @for ($i = 1; $i <= 8; $i++)
                                            <option value="{{ $i }}">Semester {{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn bg-gradient-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- ? Edit Modal --}}
@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            var dataTable = $('#matkulTable').DataTable({
                columnDefs: [{
                        targets: [3, 5],
                        orderable: false
                    },
                    {
                        searchable: true
                    }
                ]
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

            // 2. Check for Validation Errors (Error Alert)
            @if ($errors->any())
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: 'Silakan periksa kembali inputan anda.',
                });
            @endif

            // 3. Delete Confirmation Alert
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
