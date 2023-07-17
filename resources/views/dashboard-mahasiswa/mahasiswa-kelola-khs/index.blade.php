{{-- @dd($khss); --}}
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
            <h5 class="mb-0 ms-4 mt-4">Daftar Kartu Hasil Studi (KHS)</h5>
            <div class="row mx-4">
                @if (count($khss) == 0)
                    <div class="card mt-4 border ">
                        <div class="card-body ">
                            <h4 class="font-weight-normal mt-1 mb-1 text-center">Belum Mengunggah KHS</h4>
                        </div>
                    </div>
                @else
                    @foreach ($khss as $khs)
                        <div class="card mt-4 border ">
                            <!-- Card body -->
                            <div class="card-body ">
                                <h4 class="font-weight-normal mt-1 mb-1 ">Semester {{ $khs->semester }}</h4>
                                <div class="row border-top pt-3 mb-3">
                                    <div class="col-6">
                                        <p class="card-text text-sm mb-1"><strong>IP Semester:</strong>
                                            {{ $khs->ip_semester }}</p>
                                        <p class="card-text text-sm mb-1"><strong>Jumlah SKS:</strong>
                                            {{ $khs->sks_kumulatif }}</p>
                                    </div>
                                    <div class="col-6">
                                        <p class="card-text text-sm"><strong>Status Konfirmasi:</strong>
                                            {{ $khs->status_konfirmasi }}
                                        </p>
                                    </div>
                                </div>
                                <a href="{{ asset('storage/' . $khs->file_sks) }}" target="_blank"
                                    class="btn btn-info">Lihat File khs</a>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
            <div class="ms-auto me-4 mt-5">
                <a href="/dashboard-mahasiswa/kelola-khs/create" class="btn btn-primary">Unggah khs</a>
            </div>

        </div>
    </div>
@endsection

@section('scripts')
@endsection
