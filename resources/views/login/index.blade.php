@extends('login.layouts.main')

@section('content')
    <span class="mask bg-gradient-dark opacity-6"></span>
    <div class="container my-auto">
        <div class="row">
            <div class="col-lg-4 col-md-8 col-12 mx-auto">
                <div class="card z-index-0 fadeIn3 fadeInBottom">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                        <div class="bg-gradient-dark shadow-primary border-radius-lg py-3 pe-1">
                            <h4 class="text-white font-weight-bolder text-center my-1">
                                Sistem Informasi Akademik<br>Universitas Diponegoro
                            </h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <form role="form" class="text-start" action="/login" method="POST">
                            @csrf

                            <div
                                class="input-group input-group-outline my-3 @error('username') is-invalid @enderror @if (old('username')) is-filled @endif">
                                <label class="form-label">Username</label>
                                <input type="text" name="username" class="form-control" value="{{ old('username') }}"
                                    required>
                            </div>


                            <div class="input-group input-group-outline mb-1">
                                <label class="form-label">Password</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn bg-gradient-primary w-100 my-4 mb-2">Log In</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ? Modal Hubungi Admin --}}
    <div class="modal fade" id="modalHubungiAdmin" tabindex="-1" role="dialog" aria-labelledby="modalHubungiAdminLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-normal" id="modalHubungiAdminLabel">Bantuan Admin</h5>
                    <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <div class="mb-4">
                        <i class="material-icons text-info" style="font-size: 64px;">contact_support</i>
                        <h4 class="mt-3">Butuh Bantuan?</h4>
                        <p class="text-secondary">Silakan hubungi administrator melalui kontak di bawah ini jika Anda
                            mengalami kendala login.</p>
                    </div>

                    {{-- Placeholder Nomor Telp --}}
                    <div class="input-group input-group-outline is-filled mb-3">
                        <label class="form-label">Nomor WhatsApp Admin</label>
                        <input type="text" class="form-control text-center font-weight-bold" value="+62 812-3456-7890"
                            readonly>
                    </div>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Tutup</button>

                    {{-- Tombol Langsung ke WA --}}
                    <a href="https://wa.me/6281234567890?text=Halo%20Admin,%20saya%20mengalami%20kendala%20login%20di%20SIAKAD%20Undip."
                        target="_blank" class="btn bg-gradient-success d-flex align-items-center">
                        <i class="material-icons me-2">message</i> Hubungi WhatsApp
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Ambil semua elemen input di dalam grup outline
            const inputs = document.querySelectorAll('.input-group-outline input');

            inputs.forEach(input => {
                // 1. Cek saat halaman dimuat (untuk menangani Autofill browser)
                if (input.value !== "") {
                    input.parentElement.classList.add('is-filled');
                }

                // 2. Cek saat user mengetik atau klik area luar
                input.addEventListener('focusout', function() {
                    if (this.value !== "") {
                        this.parentElement.classList.add('is-filled');
                    } else {
                        this.parentElement.classList.remove('is-filled');
                    }
                });

                // 3. Listener tambahan khusus untuk mendeteksi autofill modern
                input.addEventListener('animationstart', function(e) {
                    if (e.animationName === 'onAutoFillStart') {
                        this.parentElement.classList.add('is-filled');
                    }
                });
            });
        });
        
        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Login Gagal',
                text: "{{ session('error') }}",
                // confirmButtonColor: '#e91e63' // Warna Primary Material Dashboard
            });
        @endif

        @if ($errors->has('loginError'))
            Swal.fire({
                icon: 'error',
                title: 'Akses Ditolak',
                text: "{{ $errors->first('loginError') }}",
                // confirmButtonColor: '#e91e63'
            });
        @endif

        // Cek Error Validasi Biasa (Misal: Username required)
        @if ($errors->any() && !$errors->has('loginError'))
            Swal.fire({
                icon: 'warning',
                title: 'Perhatian',
                text: 'Mohon isi semua kolom dengan benar.',
                // confirmButtonColor: '#fb8c00'
            });
        @endif
    </script>
@endsection
