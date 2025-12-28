@extends('dashboard-admin.layouts.main')


@section('content')
    <div class="row">
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
                <div class="card-header p-3 pt-2">
                    <div
                        class="icon icon-lg icon-shape bg-gradient-dark shadow-dark text-center border-radius-xl mt-n4 position-absolute">
                        <i class="material-icons opacity-10">calendar_today</i>
                    </div>
                    <div class="text-end pt-1">
                        <p class="text-sm mb-0 text-capitalize">
                            Semester Aktif
                        </p>
                        <h4 class="mb-0">{{ $semesterAktif->kode_semester }}</h4>
                    </div>
                </div>
                <hr class="dark horizontal my-0" />
                <div class="card-footer p-3">
                    <p class="mb-0">
                        {{ $semesterAktif->tanggal_mulai }} s/d {{ $semesterAktif->tanggal_selesai }}
                    </p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
                <div class="card-header p-3 pt-2">
                    <div
                        class="icon icon-lg icon-shape bg-gradient-primary shadow-primary text-center border-radius-xl mt-n4 position-absolute">
                        <i class="material-icons opacity-10">people</i>
                    </div>
                    <div class="text-end pt-1">
                        <p class="text-sm mb-0 text-capitalize">
                            Total Mahasiswa Aktif
                        </p>
                        <h4 class="mb-0">{{ $mahasiswaAktif }}</h4>
                    </div>
                </div>
                <hr class="dark horizontal my-0" />
                <div class="card-footer p-3">
                    <p class="mb-0">
                        <span class="text-danger text-sm font-weight-bolder">{{ $mahasiswaNonAktif }} </span> tidak aktif
                        <span class="text-warning text-sm font-weight-bolder">{{ $mahasiswaCuti }} </span> cuti

                    </p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
                <div class="card-header p-3 pt-2">
                    <div
                        class="icon icon-lg icon-shape bg-gradient-success shadow-success text-center border-radius-xl mt-n4 position-absolute">
                        <i class="material-icons opacity-10">person</i>
                    </div>
                    <div class="text-end pt-1">
                        <p class="text-sm mb-0 text-capitalize">
                            Total Dosen
                        </p>
                        <h4 class="mb-0">{{ $totalDosen }}</h4>
                    </div>
                </div>
                <hr class="dark horizontal my-0" />
                <div class="card-footer p-3">
                    <p class="mb-0">
                        <span class="text-danger text-sm font-weight-bolder">-2%</span>
                        than yesterday
                    </p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6">
            <div class="card">
                <div class="card-header p-3 pt-2">
                    <div
                        class="icon icon-lg icon-shape bg-gradient-danger shadow-info text-center border-radius-xl mt-n4 position-absolute">
                        <i class="material-icons opacity-10">error</i>
                    </div>
                    <div class="text-end pt-1">
                        <p class="text-sm mb-0 text-capitalize">
                            Alerts
                        </p>
                        <h4 class="mb-0">{{ $mahasiswaDataTdkLengkapCount }} Mahasiswa</h4>
                    </div>
                </div>
                <hr class="dark horizontal my-0" />
                <div class="card-footer p-3">
                    <p class="mb-0">
                        Belum melengkapi data diri
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-4 mt-md-2 mt-xl-4">
        <div class="col-xl-8 col-12">
            <div class="card">
                <div class="card-body">
                    <h5>Progres Pengisian IRS</h5>

                    <div class="chart">
                        <canvas id="chart-irs" class="chart-canvas" height="300px"></canvas>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-xl-4 col-12 mt-4 mt-xl-0">
            <div class="card">
                <div class="card-body">
                    <h5>Sebaran Status Mahasiswa</h5>
                    <div class="chart">
                        <canvas id="chart-mahasiswa" class="chart-canvas" height="300px"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-4 mt-md-2 mt-xl-4">
        <div class="col-6">
            <div class="card h-100">
                <div class="card-body">
                    <h5>Mahasiswa Data Diri Belum Lengkap</h5>

                    <div class="table-responsive" style="max-height: 250px; overflow-y: auto;">
                        <table class="table align-items-center mb-0">
                            <thead class="position-sticky top-0 bg-white z-index-1">
                                <tr>
                                    <th class="text-secondary text-sm font-weight-bolder opacity-7 ps-2">Nama</th>
                                    <th class="text-secondary text-sm font-weight-bolder opacity-7 ps-2">Data Kosong</th>
                                    <th class="text-center text-secondary text-sm font-weight-bolder opacity-7">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($mahasiswaDataTdkLengkaps as $mahasiswaDataTdkLengkap)
                                    <tr>
                                        <td class="align-middle text-sm">
                                            <span
                                                class="text-secondary text-xs font-weight-bold">{{ Str::limit($mahasiswaDataTdkLengkap->nama, 30) }}</span>
                                        </td>
                                        <td class="align-middle text-sm">
                                            <span class="text-secondary text-xs font-weight-normal"
                                                style="display: -webkit-box;
                                                        -webkit-line-clamp: 2;
                                                        -webkit-box-orient: vertical;
                                                        overflow: hidden;
                                                        text-overflow: ellipsis;
                                                        max-width: 150px;
                                                        white-space: normal;
                                                    "
                                                title="@foreach ($mahasiswaDataTdkLengkap->data_kosong as $item){{ $item }}@if (!$loop->last), @endif @endforeach">
                                                @foreach ($mahasiswaDataTdkLengkap->data_kosong as $dataKosong)
                                                    {{ $dataKosong }}@if (!$loop->last)
                                                        ,
                                                    @endif
                                                @endforeach
                                            </span>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <span class="btn btn-outline-info px-2 py-1" title="Kirim Notifikasi">
                                                <i class="material-icons opacity-10">mail</i>
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-6">
            <div class="card h-100">
                <div class="card-body">
                    <h5>Rekap PKL dan Skripsi</h5>
                    <div class="chart">
                        <canvas id="chart-pkl-skripsi" class="chart-canvas" height="200"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        var ctx = document.getElementById("chart-irs").getContext("2d");

        new Chart(ctx, {
            type: "bar",
            data: {
                // Label sumbu X (Diambil dari Controller)
                labels: {{ $angkatanAktif }},
                datasets: [{
                        label: "Belum Isi IRS",
                        tension: 0.4,
                        borderWidth: 0,
                        borderRadius: 4,
                        borderSkipped: false,
                        backgroundColor: "#EF5350", // Merah
                        data: {{ $belumMengisiIrs->values() }}, // Dummy Data
                        barThickness: 20
                    },
                    {
                        label: "Menunggu Persetujuan",
                        tension: 0.4,
                        borderWidth: 0,
                        borderRadius: 4,
                        borderSkipped: false,
                        backgroundColor: "#FFA726", // Kuning/Orange
                        data: {{ $menungguVerifikasiIrs->values() }}, // Dummy Data
                        barThickness: 20
                    },
                    {
                        label: "Sudah Disetujui",
                        tension: 0.4,
                        borderWidth: 0,
                        borderRadius: 4,
                        borderSkipped: false,
                        backgroundColor: "#66BB6A", // Hijau
                        data: {{ $sudahDikonfirmasiIrs->values() }},
                        barThickness: 20
                    },
                ],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                    }
                },
                scales: {
                    y: {
                        stacked: true,
                        grid: {
                            drawBorder: false,
                            display: true,
                            drawOnChartArea: true,
                            drawTicks: false,
                            borderDash: [5, 5],
                        },
                        ticks: {
                            display: true,
                            padding: 10,
                            color: "#b2b9bf",
                        },
                    },
                    x: {
                        stacked: true,
                        grid: {
                            drawBorder: false,
                            display: false,
                            drawOnChartArea: false,
                            drawTicks: false,
                        },
                        ticks: {
                            display: true,
                            color: "#b2b9bf",
                            padding: 10,
                        },
                    },
                },
            },
        });

        var ctx2 = document.getElementById("chart-mahasiswa").getContext("2d");

        new Chart(ctx2, {
            type: "pie",
            data: {
                labels: @json($statusMahasiswa),
                datasets: [{
                    label: "Projects",
                    weight: 9,
                    cutout: 0,
                    tension: 0.9,
                    pointRadius: 2,
                    borderWidth: 2,
                    backgroundColor: ['#66BB6A', '#FFA726', '#EF5350'],
                    data: [{{ $mahasiswaAktif }}, {{ $mahasiswaCuti }}, {{ $mahasiswaNonAktif }}],
                    fill: false
                }],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index',
                },
                scales: {
                    y: {
                        grid: {
                            drawBorder: false,
                            display: false,
                            drawOnChartArea: false,
                            drawTicks: false,
                        },
                        ticks: {
                            display: false
                        }
                    },
                    x: {
                        grid: {
                            drawBorder: false,
                            display: false,
                            drawOnChartArea: false,
                            drawTicks: false,
                        },
                        ticks: {
                            display: false,
                        }
                    },
                },
            },
        });

        var ctx3 = document.getElementById("chart-pkl-skripsi").getContext("2d");

        new Chart(ctx3, {
            type: "bar",
            data: {
                // Label Sumbu Y (Kategori)
                labels: ["PKL", "Skripsi"],
                datasets: [{
                        label: "Sudah Lulus",
                        data: [
                            {{ $statusPklCount['lulus'] }}, // Data PKL Lulus
                            {{ $statusSkripsiCount['lulus'] }} // Data Skripsi Lulus
                        ],
                        backgroundColor: "#66BB6A", // Hijau
                        barThickness: 40, // Batang lebih tebal biar enak dilihat
                    },
                    {
                        label: "Sedang Proses",
                        data: [
                            {{ $statusPklCount['progress'] }}, // Data PKL Proses
                            {{ $statusSkripsiCount['progress'] }} // Data Skripsi Proses
                        ],
                        backgroundColor: "#FFA726", // Kuning
                        barThickness: 40,
                    },
                ],
            },
            options: {
                indexAxis: 'y', // <--- INI MAGIC WORD-NYA (Bikin Horizontal)
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top', // Legend di atas
                    }
                },
                scales: {
                    x: {
                        stacked: true, // Stacked di sumbu X (karena horizontal)
                        grid: {
                            drawBorder: false,
                            display: true,
                            color: "#f0f2f5",
                        },
                        ticks: {
                            display: true,
                            color: "#b2b9bf",
                        }
                    },
                    y: {
                        stacked: true, // Stacked di sumbu Y
                        grid: {
                            drawBorder: false,
                            display: false,
                        },
                        ticks: {
                            color: "#344767",
                            font: {
                                weight: 600, // Tebalkan font label "PKL" & "Skripsi"
                                size: 14
                            }
                        }
                    },
                },
            },
        });
    </script>
@endsection
