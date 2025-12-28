@extends('dashboard-mahasiswa.layouts.main')

@section('content')
    <div class="container-fluid px-2 px-md-4 mt-4">
        <div class="row">
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-header p-3 pt-2">
                        <div
                            class="icon icon-lg icon-shape bg-gradient-primary shadow-primary text-center border-radius-xl mt-n4 position-absolute">
                            <i class="material-icons opacity-10">event_note</i>
                        </div>
                        <div class="text-end pt-1">
                            <p class="text-sm mb-0 text-capitalize">Semester</p>
                            <h4 class="mb-0">{{ $semesterAktif }}</h4>
                        </div>
                    </div>
                    <div class="card-footer py-1"></div>
                </div>
            </div>

            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-header p-3 pt-2">
                        <div
                            class="icon icon-lg icon-shape bg-gradient-dark shadow-dark text-center border-radius-xl mt-n4 position-absolute">
                            <i class="material-icons opacity-10">emoji_events</i>
                        </div>
                        <div class="text-end pt-1">
                            <p class="text-sm mb-0 text-capitalize">IP Kumulatif</p>
                            <h4 class="mb-0">
                                <small style="font-size: 40%"
                                    class="text-{{ $ipkDiff > 0 ? 'success' : 'danger' }}">{{ $ipkDiff }}</small>
                                {{ $ipk }}
                            </h4>
                        </div>
                    </div>
                    <div class="card-footer p-1"></div>
                </div>
            </div>

            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-header p-3 pt-2">
                        <div
                            class="icon icon-lg icon-shape bg-gradient-success shadow-success text-center border-radius-xl mt-n4 position-absolute">
                            <i class="material-icons opacity-10">playlist_add_check </i>
                        </div>
                        <div class="text-end pt-1">
                            <p class="text-sm mb-0 text-capitalize">SKS Kumulatif</p>
                            <h4 class="mb-0">
                                <small style="font-size: 40%" class="text-success">{{ $skskSmtBefore }}</small>
                                {{ $sksk }}
                            </h4>
                        </div>
                    </div>
                    <div class="card-footer p-1"></div>
                </div>
            </div>

            <div class="col-xl-3 col-sm-6">
                <div class="card">
                    <div class="card-header p-3 pt-2">
                        <div
                            class="icon icon-lg icon-shape bg-gradient-info shadow-info text-center border-radius-xl mt-n4 position-absolute">
                            <i class="material-icons opacity-10">supervisor_account</i>
                        </div>
                        <div class="text-end pt-1">
                            <p class="text-sm mb-0 text-capitalize">Dosen Wali</p>
                            <h4 class="mb-0">{{ $mahasiswa->dosen->nama }}</h4>
                        </div>
                    </div>
                    <div class="card-footer p-1"></div>
                </div>
            </div>
        </div>

        <div class="row mt-xl-4">
            <div class="col-lg-8 col-md-12 mb-xl-0 mb-4 d-flex">
                <div class="card w-100 h-100">
                    <div class="card-body">
                        <h5>Trend Indeks Prestasi</h5>
                        <div class="chart">
                            <canvas id="mixed-chart" class="chart-canvas" height="300px"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-12 d-flex flex-column">

                <div class="w-100 mb-4">
                    <div class="card">
                        <div class="card-header p-3 pt-2">
                            <div
                                class="icon icon-lg icon-shape bg-gradient-danger shadow-dark text-center border-radius-xl mt-n4 position-absolute">
                                <i class="material-icons opacity-10">timer</i>
                            </div>
                            <div class="text-end pt-1">
                                <p class="text-sm mb-0 text-capitalize">Countdown Semester</p>
                                <h4 class="mb-0">Sisa {{ $countdownSemester }} Hari</h4>
                            </div>
                        </div>
                        <div class="card-footer p-1"></div>
                    </div>
                </div>

                <div class="w-100 flex-grow-1 mb-xl-0 mb-4">
                    <div class="card h-100">
                        <div class="card-body d-flex flex-column justify-content-center">
                            <h5>Status Konfirmasi Pengajuan</h5>
                            <div class="d-grid gap-3 mt-3">
                                <ul class="list-group">
                                    <li
                                        class="list-group-item border-0 ps-0 pt-0 d-flex justify-content-between align-items-center">
                                        <strong class="text-dark">IRS:</strong>
                                        <span class="badge bg-gradient-{{ $irsSmtLatest->status_konfirmasi->color() }}">
                                            {{ $irsSmtLatest->status_konfirmasi->value }}
                                        </span>
                                    </li>
                                    <li
                                        class="list-group-item border-0 ps-0 d-flex justify-content-between align-items-center">
                                        <strong class="text-dark">KHS:</strong>
                                        <span class="badge bg-gradient-{{ $khsSmtLatest->status_konfirmasi->color() }}">
                                            {{ $khsSmtLatest->status_konfirmasi->value }}
                                        </span>
                                    </li>
                                    <li
                                        class="list-group-item border-0 ps-0 d-flex justify-content-between align-items-center">
                                        <strong class="text-dark">PKL:</strong>
                                        <span class="badge bg-gradient-{{ $statusPkl->color() }}">
                                            {{ $statusPkl->value }}
                                        </span>
                                    </li>
                                    <li
                                        class="list-group-item border-0 ps-0 d-flex justify-content-between align-items-center">
                                        <strong class="text-dark">Skripsi</strong>
                                        <span class="badge bg-gradient-{{ $statusSkripsi->color() }}">
                                            {{ $statusSkripsi->value }}
                                        </span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-xl-4">
            <div class="col-12 col-xl-4 mb-4">
                <div class="card h-100">
                    <div class="card-header pb-0 p-3">
                        <h5 class="mb-0">Profil Mahasiswa</h5>
                    </div>
                    <div class="card-body p-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar avatar-xl position-relative me-3">
                                <img src="/assets/img/bruce-mars.jpg" alt="profile_image"
                                    class="w-100 border-radius-lg shadow-sm">
                            </div>
                            <div class="d-flex flex-column justify-content-center">
                                <h5 class="mb-0 text-gradient text-dark font-weight-bold">
                                    {{ $mahasiswa->nama }}
                                </h5>
                                <p class="mb-0 font-weight-normal text-sm text-secondary">
                                    {{ $mahasiswa->nim }}
                                </p>
                                <span class="badge badge-sm bg-gradient-info mt-1" style="width: fit-content;">
                                    Aktif
                                </span>
                            </div>
                        </div>
                        <hr class="horizontal dark my-3">
                        <ul class="list-group">
                            <li class="list-group-item border-0 ps-0 pt-0 text-sm">
                                <strong class="text-dark">Jurusan:</strong> &nbsp; Informatika
                            </li>
                            <li class="list-group-item border-0 ps-0 text-sm">
                                <strong class="text-dark">Angkatan:</strong> &nbsp; {{ $mahasiswa->angkatan }}
                            </li>
                            <li class="list-group-item border-0 ps-0 text-sm">
                                <strong class="text-dark">Fakultas:</strong> &nbsp; Sains dan Matematika
                            </li>
                        </ul>
                        <div class="mt-4">
                            <a href="/dashboard-mahasiswa/edit-profile" class="btn btn-outline-primary btn-sm w-100 mb-0">
                                Lihat & Edit Biodata Lengkap
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-xl-8 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5>Riwayat Aktivitas Terakhir</h5>
                        <div class="table-responsive" style="max-height: 250px; overflow-y: auto;">
                            <table class="table align-items-center mb-0" id="lastActivityTable">
                                <thead class="position-sticky top-0 bg-white z-index-1">
                                    <tr>
                                        <th class="text-uppercase text-secondary text-md font-weight-bolder opacity-7"
                                            style="width: auto; white-space: nowrap;">
                                            Kategori
                                        </th>
                                        <th class="text-uppercase text-secondary text-md font-weight-bolder opacity-7 ps-2">
                                            Tanggal diunggah</th>
                                        <th
                                            class="text-uppercase text-secondary text-center text-md font-weight-bolder opacity-7 ps-2">
                                            File Terkait</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($lastActivities as $lastActivity)
                                        <tr>
                                            <td>
                                                <div class="d-flex px-2">
                                                    <div class="my-auto ms-2">
                                                        <h6 class="mb-0 text-md">{{ $lastActivity->type }}</h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <div class="d-flex">
                                                    <div class="my-auto">
                                                        <h6 class="mb-0 text-md font-weight-light">
                                                            {{ $lastActivity->created_at->format('d M Y') }}</h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-center">
                                                    <div class="my-auto">
                                                        <h6 class="mb-0 text-md font-weight-normal">
                                                            <span class="btn btn-outline-info px-2 py-2 mb-0">
                                                                <i class="material-icons opacity-10">file_present</i>
                                                            </span>
                                                        </h6>
                                                    </div>
                                                </div>
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
    </div>
@endsection

@section('scripts')
    <script>
        var ctx7 = document.getElementById("mixed-chart").getContext("2d");
        const rawLabelsSmt = {!! json_encode($ipPerSmt->keys()) !!};
        const dataIpSmt = {!! json_encode($ipPerSmt->values()) !!};
        const dataIpkPerSmt = {!! json_encode($ipkPerSmt->values()) !!};
        const labelsSmt = rawLabelsSmt.map(num => "Semester " + num);

        new Chart(ctx7, {
            data: {
                labels: labelsSmt,
                datasets: [{
                    type: "line",
                    label: "IP Kumulatif",
                    tension: 0.4,
                    borderWidth: 0,
                    pointRadius: 0,
                    pointBackgroundColor: "#e3316e",
                    borderColor: "#e3316e",
                    borderWidth: 3,
                    backgroundColor: 'transparent',
                    data: dataIpkPerSmt,
                    fill: true,
                }, {
                    type: "bar",
                    label: "IP Semester",
                    data: dataIpSmt,
                    weight: 5,
                    tension: 0.4,
                    borderWidth: 0,
                    pointBackgroundColor: "#3A416F",
                    borderColor: "#3A416F",
                    backgroundColor: '#3A416F',
                    borderRadius: 4,
                    borderSkipped: false,
                    maxBarThickness: 20
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
                            display: true,
                            drawOnChartArea: true,
                            drawTicks: false,
                            borderDash: [5, 5]
                        },
                        ticks: {
                            display: true,
                            padding: 10,
                            color: '#b2b9bf',
                            font: {
                                size: 11,
                                family: "Open Sans",
                                style: 'normal',
                                lineHeight: 2
                            },
                        }
                    },
                    x: {
                        grid: {
                            drawBorder: false,
                            display: true,
                            drawOnChartArea: true,
                            drawTicks: true,
                            borderDash: [5, 5]
                        },
                        ticks: {
                            display: true,
                            color: '#b2b9bf',
                            padding: 10,
                            font: {
                                size: 11,
                                family: "Open Sans",
                                style: 'normal',
                                lineHeight: 2
                            },
                        }
                    },
                },
            },
        });

        $(document).ready(function() {
            // Simplified DataTable: Only disabling search/ordering/paging.
            // Scrolling is handled by the HTML div wrapper now.
            $('#lastActivityTable').DataTable({
                paging: false,
                searching: false,
                info: false,
                ordering: false
            });
        });
    </script>
@endsection
