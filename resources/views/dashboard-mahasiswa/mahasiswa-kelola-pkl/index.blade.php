{{-- @dd($pkls); --}}
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
                <h4 class="mb-2">Informasi PKL</h4>
                <div class="col-6">
                    <p class=""><strong>Nama Instansi:</strong> {{ $pkls[0]->nama_perusahaan }}</p>
                    <p class=""><strong>Status Lulus:</strong> {{ $pkls[0]->status_lulus }}</p>

                </div>
                <div class="col-6">
                    <p class=""><strong>Tanggal Mulai:</strong> {{ $pkls[0]->tanggal_mulai_formatted }}</p>
                    <p class=""><strong>Tanggal Selesai:</strong> {{ $pkls[0]->tanggal_selesai_formatted }}</p>
                </div>
            </div>
            <div class="row mx-4">
                @if ($pkls == null)
                    {
                    <div class="card mt-4 border ">
                        <div class="card-body ">
                            <h4 class="font-weight-normal mt-1 mb-1 ">Belum Mengunggah PKL</h4>
                        </div>
                    </div>
                    }
                @else
                    @foreach ($pkls as $pkl)
                        <div class="card mt-4 border ">
                            <!-- Card body -->
                            <div class="card-body ">
                                <h4 class="font-weight-normal mt-1 mb-1 ">Progress Ke-{{ $pkl->progress_ke }}</h4>

                                <div class="row border-top pt-3 mb-3">
                                    <div class="col-12">
                                        <p class="card-text text-sm mb-1"><strong>Rincian Progress:</strong>
                                            {{ $pkl->rincian_progress }}</p>
                                    </div>
                                    <div class="col-6">
                                        <p class="card-text text-sm mb-1"><strong>Tanggal Diunggah:</strong>
                                            {{ $pkl->created_at->format('d M Y') }}</p>
                                    </div>
                                    <div class="col-6">
                                        <p class="card-text text-sm"><strong>Status Konfirmasi:</strong>
                                            {{ $pkl->status_konfirmasi }}
                                        </p>
                                    </div>
                                </div>
                                <a href="{{ asset('storage/' . $pkl->file_pkl) }}" target="_blank"
                                    class="btn btn-info">Lihat File pkl</a>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
            <div class="ms-auto me-4 mt-5">
                <a href="/dashboard-mahasiswa/kelola-pkl/create" class="btn btn-primary">Unggah pkl</a>
            </div>

        </div>
    </div>
@endsection

@section('scripts')
@endsection
