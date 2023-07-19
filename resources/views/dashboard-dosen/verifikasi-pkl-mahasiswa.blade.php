{{-- @dd($dosen->mahasiswa_bimbingan) --}}
@extends('dashboard-dosen.layouts.main')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">
                            Verifikasi pkl Mahasiswa
                        </h6>
                    </div>
                </div>
                {{-- <div class="card-body px-0 pb-2 ms-3" style="overflow-x: scroll;" id="scrollContainer">
                    <div class="d-flex flex-row">
                        @foreach ($angkatans as $angkatan)
                            <div class="mx-2" style="width:100vw">
                                <button id="angkatanSelector" type="button" class="btn btn-secondary"
                                    data-angkatan="{{ $angkatan->angkatan }}">{{ $angkatan->angkatan }}</button>
                            </div>
                        @endforeach
                    </div>
                </div> --}}
                <div class="card-body px-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-s font-weight-bolder opacity-10 ">
                                        NO
                                    </th>
                                    <th class="text-uppercase text-secondary text-s font-weight-bolder opacity-10 ">
                                        Foto
                                    </th>
                                    <th class="text-uppercase text-secondary text-s font-weight-bolder opacity-10">
                                        NIM
                                    </th>
                                    <th class="text-uppercase text-secondary text-s font-weight-bolder opacity-10 ps-2">
                                        Nama
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-s font-weight-bolder opacity-10">
                                        Progress<br>Ke-
                                    </th>
                                    <th
                                        class="text-uppercase text-secondary text-s font-weight-bolder opacity-10 ps-2">
                                        Nama Instansi
                                    </th>
                                    <th
                                        class="text-uppercase text-secondary text-s font-weight-bolder opacity-10 ps-2">
                                        Rincian Progress
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-s font-weight-bolder opacity-10">
                                        File PKL
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-s font-weight-bolder opacity-10">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pkls as $pkl)
                                    {{-- @dd()); --}}
                                    <tr>
                                        <td>
                                            <div class="d-flex px-3 py-1 ms-1">
                                                <p class="text-sm text-center font-weight-bold mb-0">
                                                    {{ $loop->iteration }}
                                                </p>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex px-3 py-1">
                                                <div>
                                                    <img src="{{ $pkl->mahasiswa->foto_mahasiswa }}"
                                                        class="avatar avatar-sm border-radius-lg"
                                                        alt="foto {{ $pkl->mahasiswa->nama }}" />
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex px-3 py-1">
                                                <p class="text-sm font-weight-bold mb-0">
                                                    {{ $pkl->mahasiswa->nim }}
                                                </p>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex py-1">
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm">
                                                        {{ $pkl->mahasiswa->nama }}
                                                    </h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            {{-- @dd($pkl) --}}
                                            <p class="text-sm font-weight-bold text-center mb-0">
                                                {{ $pkl->progress_ke }}
                                            </p>
                                        </td>
                                        <td>
                                            <p class="text-sm font-weight-bold  mb-0">
                                                {{ $pkl->nama_perusahaan }}
                                            </p>
                                        </td>
                                        <td>
                                            <p class="text-sm   font-weight-bold mb-0">
                                                {{ $pkl->rincian_progress }}
                                            </p>
                                        </td>
                                        <td>
                                            <p class="text-sm font-weight-bold text-center mb-0">
                                                <a href="{{ $pkl->file_pkl }}" target="_blank"><i class="fas fa-eye"></i>
                                                    Lihat File</a>

                                                {{-- {{ $mahasiswa->pkl ? $mahasiswa->pkl->status_konfirmasi : '-' }} --}}
                                            </p>
                                        </td>
                                        <td class="text-center">
                                            <a href="/dashboard-dosen/verifikasi-pkl/terima/{{ $pkl->id }}" class="badge " style="background-color: rgb(5, 173, 5)"
                                                data-bs-toggle="tooltip" title="Terima"><i data-feather="check"></i>
                                            </a>
                                            <a href="/dashboard-dosen/verifikasi-pkl/tolak/{{ $pkl->id }}" class="badge bg-danger" data-bs-toggle="tooltip" title="Tolak"><i data-feather="x"></i>
                                            </a>
                                            <p class="text-sm font-weight-bold text-center  mb-0">
                                                {{-- {{ $mahasiswa->pkl ? $mahasiswa->pkl->status_lulus : '-' }} --}}
                                            </p>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
