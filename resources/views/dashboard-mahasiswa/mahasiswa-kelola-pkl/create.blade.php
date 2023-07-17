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
                        <form method="POST" action="/dashboard-mahasiswa/kelola-pkl" enctype="multipart/form-data">
                            @csrf
                            <div class="row border-top pt-3 mb-3">
                                @if($progressKe == 1)
                                <strong>Nama Instansi</strong>
                                <div class="input-group input-group-outline ">
                                    <input type="text" name="nama_perusahaan" id="nama_perusahaan" class="form-control p-2"
                                        placeholder="Perusahaan tempat anda melakukan pkl. cth: PT Mencintaimu">
                                </div>
                                @endif
                                <div class="mt-3 mb-1">
                                    <strong>Progress Ke-</strong>
                                    <div class="input-group input-group-outline ">
                                        <input type="text" name="progress_ke" id="progress_ke" class="form-control p-2"
                                            placeholder="Masukan IP semester ini *Maks 4.00" value="{{ $progressKe }}" disabled>
                                            <input type="hidden" name="progress_ke" value="{{ $progressKe }}" required>
                                    </div>
                                </div>
                                <div class="mt-3 mb-1">
                                    <strong>Rincian Progress</strong>
                                    <div class="input-group input-group-outline ">
                                        <input type="text" name="rincian_progress" id="rincian_progress" class="form-control p-2"
                                            placeholder="Rincian Progress. cth: Menambahkan Desain" required>
                                    </div>
                                </div>
                                <div class="mt-3 mb-1">
                                    <strong>Unggah Progress</strong>
                                    <div class="input-group input-group-outline">
                                        <input type="file" name="file_pkl" id="file_pkl" class="form-control p-2" required>
                                    </div>
                                    <ul>
                                        <li>
                                            <small class="ms-1">Pastikan file berformat .pdf dan ukuran dibawah 10mb
                                                </small>
                                        </li>
                                        <li>
                                            <small class="ms-1">Pastikan nama file berformat nama_nim_semester.pdf. cth: bruce_1900018312_1.pdf
                                                </small>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-info">Unggah Progress PKL</button>
                        </form>
                    </div>
                </div>

            </div>

        </div>
    </div>
@endsection

@section('scripts')
@endsection
