@extends('dashboard-dosen.layouts.main')

@section('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                {{-- Card Header --}}
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3 align-items-center d-flex">
                            <span class="material-icons opacity-10 me-2">assignment</span>Verifikasi IRS Mahasiswa
                        </h6>
                    </div>
                </div>

                <div class="card-body px-0 pb-2">
                    <div class="table-responsive p-0 mx-2">
                        <table id="tabledata" class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th
                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">
                                        No</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Mahasiswa</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">NIM
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Angkatan</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Smt</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        SKS</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Berkas</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="tableBody">
                                @include('dashboard-dosen.partials.verifikasi-irs-table')
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        const dataTableOptions = {
            "language": {
                "emptyTable": "Tidak ada data yang tersedia pada tabel ini",
                "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
                "infoEmpty": "Menampilkan 0 sampai 0 dari 0 entri",
                "infoFiltered": "(disaring dari _MAX_ total entri)",
                "lengthMenu": "Tampilkan _MENU_ entri",
                "search": "Cari:",
                "zeroRecords": "Tidak ditemukan data yang sesuai",
                "paginate": {
                    "first": "Pertama",
                    "last": "Terakhir",
                    "next": "Selanjutnya",
                    "previous": "Sebelumnya"
                },
            }
        };

        $(document).ready(function() {
            // Initial Load
            $('#tabledata').DataTable(dataTableOptions);

            // Click event for Delete
            $(document).on('click', '.delete-confirm', function(e) {
                if (!confirm('Apakah anda yakin ingin menolak IRS ini?')) {
                    e.preventDefault();
                }
            });
        });

        function refreshTable() {
            fetch('/dashboard-dosen/verifikasi-irs/table')
                .then(response => response.text())
                .then(html => {
                    // 1. Hancurkan DataTable lama
                    if ($.fn.DataTable.isDataTable('#tabledata')) {
                        $('#tabledata').DataTable().destroy();
                    }

                    // 2. Bersihkan HTML dan Masukkan ke Body
                    // $.trim() penting untuk menghapus spasi/enter yang bikin error
                    document.getElementById('tableBody').innerHTML = $.trim(html);

                    // 3. Re-init DataTable
                    // DataTables akan otomatis mendeteksi jika body kosong dan menampilkan pesan 'emptyTable'
                    $('#tabledata').DataTable(dataTableOptions);
                })
                .catch(error => console.error('Error refreshing table:', error));
        }

        function handleValidation(id, action) {
            // 1. Confirm action (Optional but recommended)
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: action === 'approve' ? "Ingin menyetujui permintaan ini?" : "Ingin menolak permintaan ini?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Lanjutkan!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // 2. Perform AJAX Request
                    performAjax(id, action);
                }
            });
        }

        function performAjax(id, action) {
            // Construct the URL based on action
            let url = `/dashboard-dosen/irs/${id}/${action}`;

            fetch(url, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json'
                    },
                })
                .then(response => {
                    if (response.ok) return response.json();
                    throw new Error('Network response was not ok.');
                })
                .then(data => {
                    // SUCCESS: Instead of removing row, we REFRESH the table
                    refreshTable();
                    // console.log("Message from Controller:", data.data);
                    // console.log("Message from Controller:", data.message);
                    Swal.fire('Berhasil!', `Permintaan telah di-${action}.`, 'success');
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire(
                        'Gagal!',
                        'Terjadi kesalahan saat memproses permintaan.',
                        'error'
                    );
                });
        }
    </script>
@endsection
