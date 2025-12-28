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
                                            <span class="badge bg-gradient-{{ $irs->status_konfirmasi->color() }}">
                                                {{ $irs->status_konfirmasi->value }}
                                            </span>
                                        </p>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between"></div>
                                <a href="{{ asset('storage/' . $irs->file_sks) }}" target="_blank"
                                    class="btn btn-outline-info">Lihat File IRS</a>
                                @if ($irs->status_konfirmasi->value == "Ditolak")
                                    <a type="button" class="btn btn-block btn-warning " data-bs-toggle="modal"
                                        data-bs-target="#ajukanUlang{{ $irs->id }}">Ajukan Ulang</a>
                                @endif
                            </div>
                        </div>
                        {{-- Modal Ajukan Ulang --}}
                        <div class="col-md-8">
                            <div class="modal fade" id="ajukanUlang{{ $irs->id }}" tabindex="-1" role="dialog"
                                aria-labelledby="ajukanUlang{{ $irs->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered " role="document">
                                    <div class="modal-content">
                                        <div class="modal-body p-0">
                                            <div class="card card-plain">
                                                <div class="card-header pb-0 text-left">
                                                    <h5 class="">Masukan Data IRS</h5>
                                                    <p class="mb-0">Masukkan data IRS Anda dengan benar</p>

                                                </div>
                                                <div class="card-body">
                                                    <form method="POST"
                                                        action="/dashboard-mahasiswa/irs/{{ $irs->id }}"
                                                        enctype="multipart/form-data" role="form text-left">
                                                        @csrf
                                                        @method('PUT')
                                                        <strong>Jumlah SKS</strong>
                                                        <div class="input-group input-group-outline mb-3">
                                                            <input type="text" class="form-control"
                                                                value="{{ $irs->jumlah_sks }}" name="jumlah_sks"
                                                                onfocus="focused(this)" onfocusout="defocused(this)"
                                                                required>
                                                        </div>
                                                        <strong>File SKS</strong>
                                                        <div class="input-group input-group-outline mb-3">
                                                            @if ($irs->file_sks)
                                                                <div class="mb-2">
                                                                    <small>File lama:</small>
                                                                    <a href="{{ asset('storage/' . $irs->file_sks) }}"
                                                                        target="_blank" class="text-primary"
                                                                        name="file_sks">
                                                                        {{ $irs->file_sks }}
                                                                    </a>
                                                                </div>
                                                            @endif
                                                            <input type="file" class="form-control" name="file_sks"
                                                                onfocus="focused(this)" onfocusout="defocused(this)">
                                                        </div>
                                                        <input type="hidden" name="file_sks_lama"
                                                            value="{{ $irs->file_sks }}">
                                                        <div class="text-center">
                                                            <button type="submit"
                                                                class="btn btn-round bg-gradient-info btn-lg w-100 mb-0">Kirim</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
            <div class="ms-auto me-4 mt-5">
                <a href="/dashboard-mahasiswa/irs/create" class="btn btn-dark">Unggah IRS</a>
            </div>

        </div>
    </div>


@endsection

@section('scripts')
@endsection
