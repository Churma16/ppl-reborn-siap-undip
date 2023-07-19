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
                        <h4 class="font-weight-normal mt-1 mb-1 ">Ubah Data</h4>
                        <form method="post" action="/dashboard-mahasiswa/edit-profile/update/{{ $mahasiswa->nim }}">
                            @csrf
                            <div class="row border-top">
                                <div class="col-lg-6 col-md-12">
                                    <div class="mt-2 ">
                                        <strong>Nomor Induk Mahasiswa</strong>
                                        <div class="input-group input-group-outline ">
                                            <input type="text" name="" id="" class="form-control p-2"
                                                placeholder="" value="{{ $mahasiswa->nim }}" disabled>
                                        </div>
                                    </div>
                                    <div class="mt-2">
                                        <strong>Nama Lengkap</strong>
                                        <div class="input-group input-group-outline ">
                                            <input type="text" name="" id="" class="form-control p-2"
                                                placeholder="" value="{{ $mahasiswa->nama }}" disabled>
                                        </div>
                                    </div>
                                    <div class="mt-2">
                                        <strong>Angkatan</strong>
                                        <div class="input-group input-group-outline ">
                                            <input type="text" name="" id="" class="form-control p-2"
                                                placeholder="" value="{{ $mahasiswa->angkatan }}" disabled>
                                        </div>
                                    </div>
                                    <div class="mt-2">
                                        <strong>Program Studi</strong>
                                        <div class="input-group input-group-outline ">
                                            <input type="text" name="" id="" class="form-control p-2"
                                                placeholder="" value="Informatika" disabled>
                                        </div>
                                    </div>
                                    <div class="mt-2">
                                        <strong>Fakultas</strong>
                                        <div class="input-group input-group-outline ">
                                            <input type="text" name="" id="" class="form-control p-2"
                                                placeholder="" value="Sains dan Matematika" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-12">
                                    <div class="mt-2 ">
                                        <strong>Email</strong>
                                        <div class="input-group input-group-outline ">
                                            <input type="email" name="email" id="email" class="form-control p-2"
                                                placeholder="08128745698" value="{{ $mahasiswa->email }}" required>
                                        </div>
                                    </div>
                                    <div class="mt-2 ">
                                        <strong>Nomor Telepon</strong>
                                        <div class="input-group input-group-outline ">
                                            <input type="text" name="no_hp" id="no_hp" class="form-control p-2"
                                                placeholder="08128745698" value="{{ $mahasiswa->no_hp }}" required>
                                        </div>
                                    </div>
                                    <div class="mt-2">
                                        <strong>Alamat</strong>
                                        <div class="input-group input-group-outline ">
                                            <input type="text" name="alamat" id="alamat" class="form-control p-2"
                                                placeholder="Jl. lenteng agung B6/65" value="{{ $mahasiswa->alamat }}"
                                                required>
                                        </div>
                                    </div>
                                    <div class="mt-2">
                                        <strong>Provinsi</strong>
                                        <div class="input-group input-group-outline">
                                            <select name="provinsi" id="provinsi" class="form-control p-2" required>
                                                <option>Pilih Provinsi</option>
                                                @foreach ($provinsis as $provinsi)
                                                    <option
                                                        value="{{ $provinsi->kode_provinsi }}"{{ ($mahasiswa->provinsi_kode_provinsi ?? '') == $provinsi->kode_provinsi ? ' selected' : '' }}>
                                                        {{ $provinsi->nama }}
                                                    </option>
                                                @endforeach

                                            </select>
                                        </div>
                                    </div>
                                    <div class="mt-2">
                                        <strong>Kabupaten/Kota</strong>
                                        <div class="input-group input-group-outline ">
                                            <select name="kabupaten" id="kabupaten" class="form-control p-2" required>
                                                @if ($mahasiswa->kabupaten_kode_kabupaten)
                                                    <option value="{{ $mahasiswa->kabupaten_kode_kabupaten }}">
                                                        {{ $mahasiswa->kabupaten->nama }}</option>
                                                @else
                                                    <option value="">Pilih Kabupaten</option>
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-info mt-3">Update Profile</button>
                        </form>
                    </div>
                </div>

            </div>

        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            // Script will run when the document is ready

            $('#provinsi').on('change', function() {
                var provinsiID = $(this).val();

                if (provinsiID) {
                    // Make an AJAX request to retrieve kabupaten data
                    $.ajax({
                        url: '/fetch-kabupatens/' + provinsiID,
                        type: "GET",
                        data: {
                            "_token": "{{ csrf_token() }}"
                        },
                        dataType: "json",
                        success: function(data) {
                            if (data) {
                                // Clear the kabupaten dropdown
                                $('#kabupaten').empty();

                                // Add a hidden option for the kabupaten dropdown
                                $('#kabupaten').append(
                                    '<option hidden>Pilih Kabupaten</option>');

                                // Iterate over each kabupaten and add options to the dropdown
                                $.each(data, function(key, kabupaten) {
                                    $('select[name="kabupaten"]').append(
                                        '<option value="' + kabupaten
                                        .kode_kabupaten + '">' + kabupaten.nama +
                                        '</option>');
                                });
                            } else {
                                // Clear the kabupaten dropdown if no data available
                                $('#kabupaten').empty();
                            }
                        }
                    });
                } else {
                    // Clear the kabupaten dropdown if no provinsi is selected
                    $('#kabupaten').empty();
                }
            });
        });
    </script>



    <script>
        window.addEventListener('DOMContentLoaded', function() {
            var disabledInputs = document.querySelectorAll('input[disabled]');

            disabledInputs.forEach(function(input) {
                input.setAttribute('title', 'Hubungi Admin untuk mengubah data');
                input.setAttribute('data-toggle', 'tooltip');
                input.setAttribute('data-placement', 'top');
                input.addEventListener('mouseover', function() {
                    input.tooltip = new bootstrap.Tooltip(input);
                });

            });
        });
    </script>



    <script>
        $(document).ready(function() {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
@endsection
