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
            <h5 class="mb-0 ms-4 mt-4">Daftar Isian Rencana Studi (IRS)</h5>
            <div class="row mx-4">
                @if (count($irss) == 0)
                    <div class="card mt-4 border ">
                        <div class="card-body ">
                            <h4 class="font-weight-normal mt-1 mb-1 text-center">Belum Mengunggah IRS</h4>
                        </div>
                    </div>
                @else
                    @foreach ($irss as $irs)
                        <div class="card mt-4 border ">
                            <!-- Card body -->
                            <div class="card-body ">
                                <h4 class="font-weight-normal mt-1 mb-1 ">Semester {{ $irs->semester_aktif }}</h4>
                                <div class="row border-top pt-3 mb-3">
                                    <div class="col-6">
                                        <p class="card-text text-sm mb-1"><strong>Jumlah SKS:</strong>
                                            {{ $irs->jumlah_sks }}</p>
                                    </div>
                                    <div class="col-6">
                                        <p class="card-text text-sm"><strong>Status Konfirmasi:</strong>
                                            {{ $irs->status_konfirmasi }}
                                        </p>
                                    </div>
                                </div>
                                <a href="{{ asset('storage/' . $irs->file_sks) }}" target="_blank" class="btn btn-info">Lihat File IRS</a>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
            <div class="ms-auto me-4 mt-5">
                <a href="/dashboard-mahasiswa/kelola-irs/create" class="btn btn-primary">Unggah IRS</a>
            </div>

        </div>
    </div>
@endsection

@section('scripts')
@endsection
