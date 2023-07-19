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
                        <form method="get" action="/dashboard-admin/tambah-mahasiswa-baru/create">
                            @csrf
                            <div class="row border-top pt-2">
                                <div class="col-lg-6 col-md-12">
                                    <div class="mt-2">
                                        <strong>Nomor Induk Mahasiswa (NIM)</strong>
                                        <div class="input-group input-group-outline">
                                            <input type="text" name="nim" id="nim" class="form-control p-2"
                                                placeholder="Masukkan NIM di sini" value="">
                                        </div>
                                    </div>
                                    <div class="mt-2">
                                        <strong>Nama Lengkap</strong>
                                        <div class="input-group input-group-outline">
                                            <input type="text" name="nama" id="nama" class="form-control p-2"
                                                placeholder="Masukkan nama lengkap di sini" value="">
                                        </div>
                                    </div>
                                    <div class="mt-2">
                                        <strong>Email</strong>
                                        <div class="input-group input-group-outline">
                                            <input type="email" name="email" id="email" class="form-control p-2"
                                                placeholder="Masukkan email di sini" value="" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-12">
                                    <div class="mt-2">
                                        <strong>Angkatan</strong>
                                        <div class="input-group input-group-outline">
                                            <input type="text" name="angkatan" id="angkatan" class="form-control p-2"
                                                placeholder="Masukkan angkatan di sini" value="" required>
                                        </div>
                                    </div>
                                    <div class="mt-2">
                                        <strong>Jalur Masuk</strong>
                                        <div class="input-group input-group-outline">
                                            <select type="text" name="jalur_masuk" id="jalur_masuk" class="form-control p-2"
                                                required>
                                                <option value="">Pilih Jalur Masuk</option>
                                                <option value="SNMPTN">SNMPTN</option>
                                                <option value="SBMPTN">SBMPTN</option>
                                                <option value="Mandiri">Mandiri</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mt-2">
                                        <strong>Dosen Wali</strong>
                                        <div class="input-group input-group-outline">
                                            <select name="dosen_kode_wali" id="dosen_kode_wali" class="form-control p-2" required>
                                                <option value="">Pilih Dosen Wali</option>
                                                @foreach ($dosens as $dosen)
                                                    <option value="{{ $dosen->kode_wali }}">{{ $dosen->nama }}</option>
                                                @endforeach
                                            </select>
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
