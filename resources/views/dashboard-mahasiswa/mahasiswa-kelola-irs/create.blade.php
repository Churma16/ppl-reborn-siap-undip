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
                        <h4 class="font-weight-normal mt-1 mb-1 ">Masukan Data</h4>
                        <form method="POST" action="/dashboard-mahasiswa/irs" enctype="multipart/form-data">
                            @csrf
                            <div class="row border-top pt-3 mb-3">
                                <div class="col-md-6">
                                    <p class="card-text  mb-1"><strong>SKS Kumulatif:</strong> {{ $sksk }}</p>
                                </div>
                                <div class="col-md-6">
                                    <p class="card-text "><strong>Semester:</strong> {{ $semesterAktif }}</p>
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
@endsection
