{{-- @dd($mahasiswas) --}}
@extends('dashboard-departemen.layouts.main')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">
                            Data Mahasiswa
                        </h6>
                    </div>
                </div>
                <div class="card-body px-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
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
                                        class="text-uppercase text-secondary text-s text-center font-weight-bolder opacity-10">
                                        Kode Wali
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-s font-weight-bolder opacity-10">
                                        Status
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-s font-weight-bolder opacity-10">
                                        Angkatan
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-s font-weight-bolder opacity-10">
                                        Jumlah SKS
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-s font-weight-bolder opacity-10">
                                        Semester
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-s font-weight-bolder opacity-10">
                                        IP Kumulatif
                                    </th>
                                    <th class="text-secondary opacity-7"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($mahasiswas as $mahasiswa)
                                    <tr>
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
                                            <p class="text-sm text-center font-weight-bold mb-0">
                                                {{ $mahasiswa->dosen_kode_wali }}
                                            </p>
                                        </td>
                                        <td>
                                            <p class="text-sm font-weight-bold text-center mb-0">
                                                Aktif/tidakaktif
                                            </p>
                                        </td>
                                        <td>
                                            <p class="text-sm font-weight-bold text-center mb-0">
                                                {{ $mahasiswa->angkatan }}
                                            </p>
                                        </td>
                                        <td>
                                            <p class="text-sm font-weight-bold text-center  mb-0">
                                                {{ $mahasiswa->jumlah_sks }}
                                            </p>
                                        </td>
                                        <td>
                                            <p class="text-sm font-weight-bold text-center mb-0">
                                                {{ $mahasiswa->semester_aktif }}
                                            </p>
                                        </td>
                                        <td>
                                            <p class="text-sm font-weight-bold text-center mb-0">
                                                {{ $mahasiswa->ip_kumulatif }}
                                            </p>
                                        </td>
                                    </tr>
                                @endforeach
                                {{-- <tr>
                                    <td>
                                        <div class="d-flex px-2 py-1">
                                            <div>
                                                <img src="../assets/img/team-4.jpg"
                                                    class="avatar avatar-sm me-3 border-radius-lg" alt="user3" />
                                            </div>
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">
                                                    Laurent Perrier
                                                </h6>
                                                <p class="text-xs text-secondary mb-0">
                                                    laurent@creative-tim.com
                                                </p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">
                                            Executive
                                        </p>
                                        <p class="text-xs text-secondary mb-0">
                                            Projects
                                        </p>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <span class="badge badge-sm bg-gradient-success">Online</span>
                                    </td>
                                    <td class="align-middle text-center">
                                        <span class="text-secondary text-xs font-weight-bold">19/09/17</span>
                                    </td>
                                    <td class="align-middle">
                                        <a href="javascript:;" class="text-secondary font-weight-bold text-xs"
                                            data-toggle="tooltip" data-original-title="Edit user">
                                            Edit
                                        </a>
                                    </td>
                                </tr> --}}

                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('script')
@endsection
