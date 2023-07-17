{{-- @dd(dd($skripsis)); --}}
{{-- @dd(count($skripsis['items'])); --}}
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
            <div class="row px-4 pt-4">
                <h5 class="mb-2">Informasi Skripsi</h5>
                @if (count($skripsis) == 0)
                    <div class="col-6">
                        <p class=""><strong>Nama Instansi:</strong> -</p>
                        <p class=""><strong>Status Lulus:</strong> -</p>

                    </div>
                    <div class="col-6">
                        <p class=""><strong>Tanggal Mulai:</strong> -</p>
                        <p class=""><strong>Tanggal Selesai:</strong> -</p>
                    </div>
                @else
                    <div class="col-6">
                        <p class=""><strong>Judul Skripsi:</strong> {{ $skripsis[0]->judul }}</p>
                        <p class=""><strong>Status Lulus:</strong> {{ $skripsis[0]->status_skripsi }}</p>

                    </div>
                    <div class="col-6">
                        <p class=""><strong>Tanggal Mulai:</strong> {{ $skripsis[0]->tanggal_mulai_formatted }}</p>
                        <p class=""><strong>Tanggal Selesai:</strong> {{ $skripsis[0]->tanggal_sidang_formatted }}
                        </p>
                    </div>
                @endif
            </div>
            
            <h5 class="mb-0 ms-4 mt-4">Daftar Progress</h5>
            <div class="row mx-4">
                @if (count($skripsis) == 0)
                    <div class="card mt-4 border ">
                        <div class="card-body ">
                            <h4 class="font-weight-normal mt-1 mb-1 fw-bolder text-center">Belum Mengunggah Skripsi</h4>
                        </div>
                    </div>
                @else
                    @foreach ($skripsis as $skripsi)
                        <div class="card mt-4 border ">
                            <!-- Card body -->
                            <div class="card-body ">
                                <h4 class="font-weight-normal mt-1 mb-1 ">Progress Ke-{{ $skripsi->progress_ke }}</h4>

                                <div class="row border-top pt-3 mb-3">
                                    <div class="col-12">
                                        <p class="card-text text-sm mb-1"><strong>Rincian
                                                Progress:</strong> {{ $skripsi->rincian_progress }}
                                        </p>
                                    </div>
                                    <div class="col-6">
                                        <p class="card-text text-sm mb-1"><strong>Tanggal Diunggah:</strong>
                                            {{ $skripsi->created_at->format('d M Y') }}
                                        </p>
                                    </div>
                                    <div class="col-6">
                                        <p class="card-text text-sm"><strong>Status Konfirmasi:</strong>
                                            {{ $skripsi->status_konfirmasi }}

                                        </p>
                                    </div>
                                </div>
                                <a href="{{ asset('storage/' . $skripsi->file_skripsi) }}" target="_blank"
                                    class="btn btn-info">Lihat File Skripsi</a>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
            <div class="ms-auto me-4 mt-5">
                <a href="/dashboard-mahasiswa/kelola-skripsi/create" class="btn btn-primary">Unggah Skripsi</a>
            </div>

        </div>
    </div>
@endsection

@section('scripts')
@endsection
