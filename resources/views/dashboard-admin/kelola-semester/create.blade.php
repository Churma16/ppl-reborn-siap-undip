{{-- @dd($irss); --}}
@extends('dashboard-admin.layouts.main')
@section('content')
    <h3 class="ms-4">{{ $title }}</h3>
    <div class="container-fluid px-2 px-md-4 mt-4">
        <div class="card card-body  mt-4">
            <div class="row mx-4 mb-4">
                <div class="card mt-4 border ">
                    <!-- Card body -->
                    <div class="card-body ">
                        <h4 class="font-weight-normal mt-1 mb-1 ">Masukan Data</h4>
                        <form method="post" action="/dashboard-admin/kelola-semester">
                            @csrf
                            <div class="row border-top pt-2">
                                <div class="col-lg-6 col-md-12">
                                    <div class="mt-2">
                                        <strong>Nama Semester:</strong>
                                        <div class="input-group input-group-outline">
                                            <input type="text" name="nama_semester" id="nama_semester"
                                                class="form-control p-2" placeholder="Masukkan nama semester di sini"
                                                value="">
                                        </div>
                                    </div>
                                    <div class="mt-2">
                                        <strong>Status Semester:</strong>
                                        <div class="input-group input-group-outline">
                                            <select type="text" name="status_semester" id="status_semester"
                                                class="form-control p-2" required>
                                                <option value="">Pilih Status Semester</option>
                                                <option value="True">Aktif</option>
                                                <option value="False">Tidak Aktif</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-12">
                                    <div class="mt-2">
                                        <strong>Tanggal Mulai:</strong>
                                        <div class="input-group input-group-outline">
                                            <input type="date" name="tanggal_mulai" id="tanggal_mulai"
                                                class="form-control p-2" placeholder="Masukkan tanggal mulai di sini"
                                                value="">
                                        </div>
                                    </div>
                                    <div class="mt-2">
                                        <strong>Tanggal Selesai:</strong>
                                        <div class="input-group input-group-outline">
                                            <input type="date" name="tanggal_selesai" id="tanggal_selesai"
                                                class="form-control p-2" placeholder="Masukkan tanggal selesai di sini"
                                                value="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-info mt-3">Tambahkan Data</button>
                        </form>
                    </div>
                </div>

            </div>

        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


    <script>
        $(document).ready(function() {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
@endsection
