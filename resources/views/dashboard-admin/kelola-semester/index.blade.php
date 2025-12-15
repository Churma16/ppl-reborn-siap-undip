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
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">
                            Data Semester
                        </h6>
                    </div>
                </div>
                {{-- <div class="card-body px-0 pb-2 ms-3" style="overflow-x: scroll;" id="scrollContainer">
                    <div class="d-flex flex-row">
                        @foreach ($angkatans as $angkatan)
                            <div class="mx-2" style="width:100vw">
                                <button id="angkatanSelector" type="button" class="btn btn-secondary"
                                    data-angkatan="{{ $angkatan->angkatan }}">{{ $angkatan->angkatan }}</button>
                            </div>
                        @endforeach
                    </div>
                </div> --}}
                <div class="card-body px-0 pb-4">
                    <div class="row px-4 pb-4">
                        {{-- <h6>Cari Berdasarkan</h6>
                        <div class="col input-group input-group-outline">
                            <input type="text" name="nimSearch" id="nimSearch" class="form-control p-2" placeholder="NIM"
                                required>
                        </div>
                        <div class="col input-group input-group-outline">
                            <input type="text" name="namaSearch" id="namaSearch" class="form-control p-2"
                                placeholder="Nama" required>
                        </div>
                        <div class="col input-group input-group-outline">
                            <select name="kodeWaliSearch" id="kodeWaliSearch" class="form-control p-2">
                                <option class="text-secondary" value="" selected>Kode Wali</option>
                                @foreach ($dosens as $dosen)
                                    <option value="{{ $dosen->kode_wali }}">{{ $dosen->kode_wali }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col input-group input-group-outline">
                            <input type="text" name="angkatanSearch" id="angkatanSearch" class="form-control p-2"
                                placeholder="Angkatan" required>
                        </div>
                        <div class="col input-group input-group-outline">
                            <input type="text" name="statusSearch" id="statusSearch" class="form-control p-2"
                                placeholder="Status" required>
                        </div> --}}
                    </div>
                    <div class="table-responsive p-0 mx-4">
                        <table class="table align-items-center mb-0 " id="semesterTable">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-s font-weight-bolder opacity-10 ">
                                        No
                                    </th>
                                    <th class="text-uppercase text-secondary text-s font-weight-bolder opacity-10">
                                        Kode Semester
                                    </th>
                                    <th class="text-uppercase text-secondary text-s font-weight-bolder opacity-10 ps-2">
                                        Nama
                                    </th>
                                    <th
                                        class="text-uppercase text-secondary text-s text-center font-weight-bolder opacity-10">
                                        Status
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-s font-weight-bolder opacity-10">
                                        Tanggal Mulai
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-s font-weight-bolder opacity-10">
                                        Tanggal Selesai
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-s font-weight-bolder opacity-10">
                                        Jumlah SKS
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-s font-weight-bolder opacity-10">
                                        Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($semesters as $semester)
                                    <tr>
                                        <td>
                                            <div class="d-flex px-3 py-1">
                                                <p class="text-sm font-weight-bold mb-0 ps-1">
                                                    {{ $loop->iteration }}
                                                </p>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex px-3 py-1">
                                                <p class="text-sm font-weight-bold mb-0">
                                                    {{ $semester->kode_semester }}
                                                </p>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex py-1">
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm">
                                                        {{ $semester->nama_semester }}
                                                    </h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-sm font-weight-bold text-center mb-0">
                                                @if ($semester->is_active == 1)
                                                    <span class="badge bg-gradient-success">Aktif</span>
                                                @else
                                                    <span class="badge bg-gradient-danger">Tidak Aktif</span>
                                                @endif
                                            </p>
                                        </td>
                                        <td>
                                            <p class="text-sm text-center font-weight-bold mb-0">
                                                {{ $semester->tanggal_mulai }}
                                            </p>
                                        </td>
                                        <td>
                                            <p class="text-sm text-center font-weight-bold mb-0">
                                                {{ $semester->tanggal_selesai }}
                                            </p>
                                        </td>
                                        <td>
                                            <p class="text-sm font-weight-bold text-center mb-0">
                                                @if ($semester->status_aktif)
                                                    <span class="badge bg-gradient-success">Aktif</span>
                                                @else
                                                    <span class="badge bg-gradient-danger">Tidak Aktif</span>
                                                @endif
                                            </p>
                                        </td>
                                        <td>
                                            <a href="test" class="badge bg-gradient-warning">
                                                <i class="material-icons opacity-10">edit</i>
                                            </a>
                                            <form action="/dashboard-admin/kelola-semester/{{ $semester->id }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('delete')
                                                <button type="button" class="badge bg-gradient-danger border-0"
                                                    onclick="return confirm('Are you sure you want to delete this data?') ? this.parentElement.submit() : false;">
                                                    <i class="material-icons opacity-10">delete</i>
                                                </button>
                                            </form>

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
@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            //     $(".angkatanSelector").click(function() {
            //         var angkatan = $(this).data("angkatan");
            //         $.ajax({
            //             url: "/your-api-endpoint",
            //             type: "POST",
            //             data: {
            //                 angkatan: angkatan
            //             },
            //             success: function(response) {
            //                 $("#tableContainer").html(response);
            //             },
            //             error: function(xhr) {
            //                 console.log(xhr.responseText);
            //             }
            //         });
            //     });

            var dataTable = $('#semesterTable').DataTable({
                // DataTable initialization options
                columnDefs: [{
                        targets: [3, 5],
                        orderable: false
                    }, // Disable sorting for columns 1 and 2 (column indexes start from 0)
                    {
                        // targets: [2, 3, 4, 5, 6],
                        searchable: true
                    }
                ]
            });

            // Search by NIM
            // $('#nimSearch').on('keyup', function() {
            //     dataTable.column(2).search(this.value).draw();
            // });

            // Search by Nama
            // $('#namaSearch').on('keyup', function() {
            //     dataTable.column(3).search(this.value).draw();
            // });

            // Search by Kode Wali (using select dropdown)
            // $('#kodeWaliSearch').on('change', function() {
            //     var selectedValue = $(this).val();
            //     dataTable.column(4).search(selectedValue).draw();
            // });

            // Search by Angkatan
            // $('#angkatanSearch').on('keyup', function() {
            //     dataTable.column(6).search(this.value).draw();
            // });

            // Search by Status
            // $('#statusSearch').on('keyup', function() {
            //     var searchTerm = this.value.toLowerCase();
            //     dataTable.column(5).search(function(cellData, searchData) {
            //         var badgeContent = $(cellData).find('.badge').text().toLowerCase();
            //         return badgeContent === searchTerm;
            //     }).draw();
            // });


        });
    </script>
@endsection
