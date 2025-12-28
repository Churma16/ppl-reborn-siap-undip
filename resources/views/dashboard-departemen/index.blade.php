{{-- @dd($mahasiswa->aktif_pkl) --}}
@extends('dashboard-departemen.layouts.main')


@section('content')
    <div class="row">
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
                <div class="card-header p-3 pt-2">
                    <div
                        class="icon icon-lg icon-shape bg-gradient-dark shadow-dark text-center border-radius-xl mt-n4 position-absolute">
                        <i class="material-icons opacity-10">group</i>
                    </div>
                    <div class="text-end pt-1">
                        <p class="text-sm mb-0 text-capitalize">
                            Rerata Ipk Semester Lalu
                        </p>
                        <h4 class="mb-0">{{ $rerataMhsSemesterLalu }}</h4>
                    </div>
                </div>
                <hr class="dark horizontal my-0" />

                <div class="card-footer px-4 py-2">
                    <p class="mb-0">
                        <span class="text-success text-sm font-weight-bolder">+55% </span>than last week
                    </p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
                <div class="card-header p-3 pt-2">
                    <div
                        class="icon icon-lg icon-shape bg-gradient-primary shadow-primary text-center border-radius-xl mt-n4 position-absolute">
                        <i class="material-icons opacity-10">school</i>
                    </div>
                    <div class="text-end pt-1">
                        <p class="text-sm mb-0 text-capitalize">
                            Calon Wisuda
                        </p>
                        <h4 class="mb-0">{{ $calonWisudaCount }}</h4>
                    </div>
                </div>
                <hr class="dark horizontal my-0" />
                <div class="card-footer px-4 py-2">
                    <p class="mb-0">
                        <span
                            class="text-{{ $calonWisudaDiff < 0 ? 'danger' : 'success' }} text-sm font-weight-bolder">{{ $calonWisudaDiff }}
                        </span>dibanding semester lalu
                    </p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
                <div class="card-header p-3 pt-2">
                    <div
                        class="icon icon-lg icon-shape bg-gradient-danger shadow-danger text-center border-radius-xl mt-n4 position-absolute">
                        <i class="material-icons opacity-10">warning</i>
                    </div>
                    <div class="text-end pt-1">
                        <p class="text-sm mb-0 text-capitalize">
                            Mahasiswa Kritis
                        </p>
                        <h4 class="mb-0">{{ $mhsKritis }}</h4>
                    </div>
                </div>
                <hr class="dark horizontal my-0" />
                <div class="card-footer px-4 py-2">
                    <p class="mb-0">
                        semester > 2 dengan ipk < 2.00 </p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6">
            <div class="card">
                <div class="card-header p-3 pt-2">
                    <div
                        class="icon icon-lg icon-shape bg-gradient-info shadow-info text-center border-radius-xl mt-n4 position-absolute">
                        <i class="material-icons opacity-10">percent</i>
                    </div>
                    <div class="text-end pt-1">
                        <p class="text-sm mb-0 text-capitalize">
                            Rasio Dosen/Mahasiswa
                        </p>
                        <h4 class="mb-0 {{ $rasioColor }}">{{ $rasioDosenMahasiswa }}</h4>
                    </div>
                </div>
                <hr class="dark horizontal my-0" />
                <div class="card-footer px-4 py-2">
                    <p class="mb-0 ">
                        Beban Terberat: {{ $bebanDoswal->keys()->first() }} </p>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-8">
            <div class="card">
                <div class="card-body">
                    <h5>Monitoring Tingkat Akhir</h5>
                    <div class="chart">
                        <canvas id="chart-pkl-skripsi" class="chart-canvas" height="200"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="card">
                <div class="card-body">
                    <h5>Beban Dosen</h5>
                    <div class="chart">
                        <canvas id="chart-beban-dosen" class="chart-canvas" height="200"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <h5>Daftar Mahasiswa Perlu Perhatian</h5>
                    <div class="table-responsive">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-sm font-weight-bolder ">Nama
                                    </th>

                                    <th class="text-center text-uppercase text-secondary text-sm font-weight-bolder ">
                                        Angkatan
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-sm font-weight-bolder  ps-2">
                                        Semester</th>
                                    <th class="text-center text-uppercase text-secondary text-sm font-weight-bolder ">
                                        IPK</th>
                                    <th class="text-center text-uppercase text-secondary text-sm font-weight-bolder ">
                                        SKS</th>
                                    <th class="text-center ">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    @foreach ($listMhsKritis as $mhsKritis)
                                        <td class="">
                                            <h6 class="text-secondary text-xs ps-2">{{ $mhsKritis->nama }}</h6>
                                        </td>
                                        <td class="align-middle text-center">

                                            <span
                                                class="text-secondary text-xs font-weight-normal">{{ $mhsKritis->angkatan }}</span>
                                        </td>
                                        <td class="align-middle text-center">

                                            <span
                                                class="text-secondary text-xs font-weight-normal">{{ $mhsKritis->khsTerakhir->semester }}</span>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <span
                                                class="text-secondary text-xs font-weight-normal">{{ $mhsKritis->khsTerakhir->ip_kumulatif }}</span>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span
                                                class="text-secondary text-xs font-weight-normal">{{ $mhsKritis->khsTerakhir->sks_kumulatif }}</span>
                                        </td>
                                        <td class="align-middle text-center ">
                                            <a class="btn btn-outline-info px-2 py-1" href="mailto:{{ $mhsKritis->email }}"
                                                title="Kirim Email">
                                                <i class="material-icons opacity-10">mail</i>
                                            </a>
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



    <div class="row mb-4">

        {{-- <div class="col-lg-4 col-md-6">
            <div class="card h-100">
                <div class="card-header pb-0">
                    <h6>Orders overview</h6>
                    <p class="text-sm">
                        <i class="fa fa-arrow-up text-success" aria-hidden="true"></i>
                        <span class="font-weight-bold">24%</span>
                        this month
                    </p>
                </div>
                <div class="card-body p-3">
                    <div class="timeline timeline-one-side">
                        <div class="timeline-block mb-3">
                            <span class="timeline-step">
                                <i class="material-icons text-success text-gradient">notifications</i>
                            </span>
                            <div class="timeline-content">
                                <h6 class="text-dark text-sm font-weight-bold mb-0">
                                    $2400, Design changes
                                </h6>
                                <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">
                                    22 DEC 7:20 PM
                                </p>
                            </div>
                        </div>
                        <div class="timeline-block mb-3">
                            <span class="timeline-step">
                                <i class="material-icons text-danger text-gradient">code</i>
                            </span>
                            <div class="timeline-content">
                                <h6 class="text-dark text-sm font-weight-bold mb-0">
                                    New order #1832412
                                </h6>
                                <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">
                                    21 DEC 11 PM
                                </p>
                            </div>
                        </div>
                        <div class="timeline-block mb-3">
                            <span class="timeline-step">
                                <i class="material-icons text-info text-gradient">shopping_cart</i>
                            </span>
                            <div class="timeline-content">
                                <h6 class="text-dark text-sm font-weight-bold mb-0">
                                    Server payments for April
                                </h6>
                                <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">
                                    21 DEC 9:34 PM
                                </p>
                            </div>
                        </div>
                        <div class="timeline-block mb-3">
                            <span class="timeline-step">
                                <i class="material-icons text-warning text-gradient">credit_card</i>
                            </span>
                            <div class="timeline-content">
                                <h6 class="text-dark text-sm font-weight-bold mb-0">
                                    New card added for order
                                    #4395133
                                </h6>
                                <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">
                                    20 DEC 2:20 AM
                                </p>
                            </div>
                        </div>
                        <div class="timeline-block mb-3">
                            <span class="timeline-step">
                                <i class="material-icons text-primary text-gradient">key</i>
                            </span>
                            <div class="timeline-content">
                                <h6 class="text-dark text-sm font-weight-bold mb-0">
                                    Unlock packages for development
                                </h6>
                                <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">
                                    18 DEC 4:54 AM
                                </p>
                            </div>
                        </div>
                        <div class="timeline-block">
                            <span class="timeline-step">
                                <i class="material-icons text-dark text-gradient">payments</i>
                            </span>
                            <div class="timeline-content">
                                <h6 class="text-dark text-sm font-weight-bold mb-0">
                                    New order #9583120
                                </h6>
                                <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">
                                    17 DEC
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
    </div>
@endsection

@section('scripts')
    <script>

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
                    {
                        label: "Belum Ambil",
                        data: [
                            {{ $statusPklCount['belum_ambil'] }}, // Data PKL Proses
                            {{ $statusSkripsiCount['belum_ambil'] }} // Data Skripsi Proses
                        ],
                        backgroundColor: "#e94440", // Kuning
                        barThickness: 40,
                    },
                ],
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                    }
                },
                scales: {
                    x: {
                        stacked: true,
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
                        stacked: true,
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

        var ctx5 = document.getElementById("chart-beban-dosen").getContext("2d");

        new Chart(ctx5, {
            type: "bar", // Tipe Bar Biasa (Vertikal)
            data: {
                labels: @json($bebanDoswal->keys()), // Dummy data
                datasets: [{
                    label: "Jumlah Mahasiswa",
                    tension: 0.4,
                    borderWidth: 0,
                    borderRadius: 4,
                    borderSkipped: false,
                    backgroundColor: "#344767", // Warna Gelap (Dark Blue) biar elegan
                    data: @json($bebanDoswal->values()), // Dummy data
                    maxBarThickness: 60 // Jangan terlalu gemuk barnya
                }],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false, // Tidak butuh legend karena cuma 1 kategori
                    }
                },
                scales: {
                    y: {
                        grid: {
                            drawBorder: true,
                            display: true,
                            drawOnChartArea: true,
                            drawTicks: false,
                            borderDash: [5, 5],
                            color: '#c1c4ce5c'
                        },
                        ticks: {
                            display: true,
                            color: "#b2b9bf",
                        }
                    },
                    x: {
                        grid: {
                            drawBorder: false,
                            display: false,
                            drawOnChartArea: false,
                            drawTicks: false,
                            borderDash: [5, 5]
                        },
                        ticks: {
                            display: true,
                            color: "#344767", // Warna Nama Dosen
                            padding: 10,
                            font: {
                                size: 11, // Agak kecil biar nama panjang muat
                                family: "Roboto",
                                style: 'normal',
                                lineHeight: 2
                            },
                        },
                    },
                },
            },
        });
    </script>
@endsection
