{{-- @dd($irss); --}}
@extends('dashboard-mahasiswa.layouts.main')
@section('content')
    <h3 class="ms-4">{{ $title }}</h3>
    <div class="container-fluid px-2 px-md-4 mt-4">
        <div class="card card-body  mt-4">
            <div class="row gx-4 mb-2 ms-1">
                <div class="col-auto">
                    <div class="avatar avatar-xl position-relative">
                        <img src="/assets/img/bruce-mars.jpg" alt="profile_image" class="w-100 border-radius-lg shadow-sm">
                    </div>
                </div>
                <div class="col-auto my-auto">
                    <div class="h-100">
                        <h4 class="mb-1">
                            {{ $mahasiswa->nama }}
                        </h4>
                        <p class="mb-0 font-weight-normal text-sm">
                            {{ $mahasiswa->nim }}
                        </p>
                    </div>
                </div>
            </div>
            <div class="row mx-4 mb-4">
                <div class="card mt-4 border ">
                    <!-- Card body -->
                    <div class="card-body ">
                        <h4 class="font-weight-normal mt-1 mb-1 ">Ubah Data</h4>
                        <div class="row border-top">
                            <div class="col-lg-6 col-md-12">
                                <div class="mt-2 ">
                                    <strong>Nomor Induk Mahasiswa</strong>
                                    <div class="input-group input-group-outline ">
                                        <input type="text" name="" id="" class="form-control p-2"
                                            placeholder="" value="{{ $mahasiswa->nim }}" disabled>
                                    </div>
                                </div>
                                <div class="mt-2">
                                    <strong>Nama Lengkap</strong>
                                    <div class="input-group input-group-outline ">
                                        <input type="text" name="" id="" class="form-control p-2"
                                            placeholder="" value="{{ $mahasiswa->nama }}" disabled>
                                    </div>
                                </div>
                                <div class="mt-2">
                                    <strong>Angkatan</strong>
                                    <div class="input-group input-group-outline ">
                                        <input type="text" name="" id="" class="form-control p-2"
                                            placeholder="" value="{{ $mahasiswa->angkatan }}" disabled>
                                    </div>
                                </div>
                                <div class="mt-2">
                                    <strong>Program Studi</strong>
                                    <div class="input-group input-group-outline ">
                                        <input type="text" name="" id="" class="form-control p-2"
                                            placeholder="" value="Informatika" disabled>
                                    </div>
                                </div>
                                <div class="mt-2">
                                    <strong>Fakultas</strong>
                                    <div class="input-group input-group-outline ">
                                        <input type="text" name="" id="" class="form-control p-2"
                                            placeholder="" value="Sains dan Matematika" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12">
                                <div class="mt-2 ">
                                    <strong>Nomor Telepon</strong>
                                    <div class="input-group input-group-outline ">
                                        <input type="text" name="" id="" class="form-control p-2"
                                            placeholder="" value="{{ $mahasiswa->no_hp }}">
                                    </div>
                                </div>
                                <div class="mt-2">
                                    <strong>Alamat</strong>
                                    <div class="input-group input-group-outline ">
                                        <input type="text" name="" id="" class="form-control p-2"
                                            placeholder="" value="{{ $mahasiswa->alamat }}">
                                    </div>
                                </div>
                                <div class="mt-2">
                                    <strong>Provinsi</strong>
                                    <div class="input-group input-group-outline">
                                        <select name="" id="" class="form-control p-2">
                                            @foreach ($provinsis as $provinsi)
                                                <option value="{{ $provinsi->kode_provinsi }}"
                                                    {{ $mahasiswa->provinsi_kode_provinsi == $provinsi->kode_provinsi ? 'selected' : '' }}>
                                                    {{ $provinsi->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="mt-2">
                                    <strong>Kabupaten/Kota</strong>
                                    <div class="input-group input-group-outline ">
                                        <input type="text" name="" id="" class="form-control p-2"
                                            placeholder="">
                                    </div>
                                </div>
                                <div class="mt-2">
                                    <strong>Fakultas</strong>
                                    <div class="input-group input-group-outline ">
                                        <input type="text" name="" id="" class="form-control p-2"
                                            placeholder="">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <form method="POST" action="/dashboard-mahasiswa/kelola-irs" enctype="multipart/form-data">
                            @csrf
                            <div class="row border-top pt-3 mb-3">
                                <div class="col-6">
                                    <p class="card-text  mb-1"><strong>SKS Kumulatif:</strong> </p>
                                </div>
                                <div class="col-6">
                                    <p class="card-text "><strong>Semester:</strong> </p>
                                </div>
                                <div class="mt-3 mb-1">
                                    <strong>SKS Semester</strong>
                                    <div class="input-group input-group-outline ">
                                        <input type="text" name="jumlah_sks" id="jumlah_sks" class="form-control p-2"
                                            placeholder="Masukan Banyak SKS yang diambil semester ini *Maks 24">
                                    </div>
                                </div>
                                <div class="mt-3 mb-1">
                                    <strong>Upload Scan IRS</strong>
                                    <div class="input-group input-group-outline">
                                        <input type="file" name="file_sks" id="file_sks" class="form-control p-2">
                                    </div>
                                    <ul>
                                        <li>
                                            <small class="ms-1">Pastikan file berformat .pdf dan ukuran dibawah 10mb
                                            </small>
                                        </li>
                                        <li>
                                            <small class="ms-1">Pastikan nama file berformat nama_nim_semester.pdf. cth:
                                                bruce_1900018312_1.pdf
                                            </small>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-info">Unggah File IRS</button>
                        </form>
                    </div>
                </div>

            </div>

        </div>
    </div>
@endsection

@section('scripts')
    <script></script>

    <script>
        window.addEventListener('DOMContentLoaded', function() {
            var disabledInputs = document.querySelectorAll('input[disabled]');

            disabledInputs.forEach(function(input) {
                input.setAttribute('title', 'Hubungi Admin untuk mengubah data');
                input.setAttribute('data-toggle', 'tooltip');
                input.setAttribute('data-placement', 'top');
                input.addEventListener('mouseover', function() {
                    input.tooltip = new bootstrap.Tooltip(input);
                });
            });
        });
    </script>

    <script>
        $(function() {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>
@endsection
