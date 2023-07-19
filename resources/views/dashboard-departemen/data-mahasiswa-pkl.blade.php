{{-- @dd($mahasiswas) --}}
@extends('dashboard-departemen.layouts.main')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">
                            Data Mahasiswa PKL
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
                                        No
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
                                        Angkatan
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-s font-weight-bolder opacity-10">
                                        Semester
                                    </th>
                                    <th class="text-uppercase text-secondary text-s font-weight-bolder opacity-10 ps-2">
                                        Instansi PKL
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-s font-weight-bolder opacity-10">
                                        Status Lulus
                                    </th>

                                    <th
                                        class="text-center text-uppercase text-secondary text-s font-weight-bolder opacity-10">
                                        Tanggal <br>Mulai
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-s font-weight-bolder opacity-10">
                                        Tanggal <br>Selesai
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-s font-weight-bolder opacity-10">
                                        File PKL
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($mahasiswas as $mahasiswa)
                                    <tr>
                                        <td>
                                            <div class="d-flex px-3 py-1">
                                                <p class="text-sm font-weight-bold mb-0 ps-1">
                                                    {{ $loop->iteration }}
                                                </p>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex px-3 py-1">
                                                <div>
                                                    <img src="{{ $mahasiswa->foto_mahasiswa }}"
                                                        class="avatar avatar-sm border-radius-lg"
                                                        alt="foto {{ $mahasiswa->nama }}" />
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex px-3 py-1">
                                                <p class="text-sm font-weight-bold mb-0">
                                                    {{ $mahasiswa->nim }}
                                                </p>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex py-1">
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm">
                                                        {{ $mahasiswa->nama }}
                                                    </h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-sm font-weight-bold text-center mb-0">
                                                {{ $mahasiswa->angkatan }}
                                            </p>
                                        </td>
                                        <td>
                                            <p class="text-sm font-weight-bold text-center mb-0">
                                                {{ $mahasiswa->semester_aktif }}
                                            </p>
                                        </td>
                                        <td>
                                            <p class="text-sm  font-weight-bold mb-0">
                                                {{ $mahasiswa->pkl ? $mahasiswa->pkl->nama_perusahaan : '-' }}
                                            </p>
                                        </td>

                                        <td>
                                            <p class="text-sm font-weight-bold text-center  mb-0">
                                                @if ($mahasiswa->pkl == null)
                                                    <span class="badge bg-gradient-danger">Belum PKL</span>
                                                @elseif ($mahasiswa->pkl->status_lulus == 'Lulus')
                                                    <span class="badge bg-gradient-success">Lulus</span>
                                                @elseif($mahasiswa->pkl->status_lulus == 'Belum Lulus')
                                                    <span class="badge bg-gradient-info">Belum Lulus</span>
                                                @endif
                                            </p>
                                        </td>
                                        <td>
                                            <p class="text-sm font-weight-bold text-center mb-0">
                                                {{ $mahasiswa->pkl ? $mahasiswa->pkl->tanggal_mulai_formatted : '-' }}
                                            </p>
                                        </td>
                                        <td>
                                            <p class="text-sm font-weight-bold text-center  mb-0">
                                                {{ $mahasiswa->pkl ? $mahasiswa->pkl->tanggal_selesai_formatted : '-' }}
                                            </p>
                                        </td>
                                        <td>
                                            <p class="text-sm font-weight-bold text-center mb-0">
                                                {!! $mahasiswa->Skripsi ? '<a href="' . $mahasiswa->skripsi->file_skripsi . '" target="_blank">Unduh</a>' : '-' !!}
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

@section('script')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $(".angkatanSelector").click(function() {
                var angkatan = $(this).data("angkatan");
                $.ajax({
                    url: "/your-api-endpoint",
                    type: "POST",
                    data: {
                        angkatan: angkatan
                    },
                    success: function(response) {
                        $("#tableContainer").html(response);
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                    }
                });
            });
        });
    </script>
@endsection
