<aside
    class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3 bg-gradient-dark"
    id="sidenav-main">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-white opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
            aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand m-0" href=" https://demos.creative-tim.com/material-dashboard/pages/dashboard "
            target="_blank">
            <img src="img/logo-undip.png" class="navbar-brand-img h-100" alt="main_logo"
                style="filter: drop-shadow(0 0 8px rgba(255, 255, 255, 0.5));" />
            <span class="ms-1 text-white">SIAP</span> <span class=" font-weight-bold text-white">UNDIP</span>
        </a>
    </div>
    <hr class="horizontal light mt-0 mb-2" />
    <div class="collapse navbar-collapse w-auto" id="sidenav-collapse-main"
        style="height: calc(100vh - 180px); overflow-y: auto;">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link text-white {{ Request::is('dashboard-dosen') ? 'bg-gradient-primary' : '' }} "
                    href="/dashboard-dosen">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">dashboard</i>
                    </div>
                    <span class="nav-link-text ms-1">Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white {{ Request::is('dashboard-dosen/verifikasi-irs') ? 'bg-gradient-primary' : '' }}"
                    href="/dashboard-dosen/verifikasi-irs">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">assignment</i>
                    </div>
                    <span class="nav-link-text ms-1 text-wrap" style="line-height: 1.2;">Verifikasi IRS Mahasiswa</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white d-flex align-items-center justify-content-between {{ Request::is('dashboard-dosen/verifikasi-khs') ? 'bg-gradient-primary' : '' }}"
                    href="/dashboard-dosen/verifikasi-khs">
                    <div class="d-flex align-items-center">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">assessment</i>
                        </div>
                        <span class="nav-link-text ms-1 text-wrap" style="line-height: 1.2;">
                            Verifikasi KHS Mahasiswa
                        </span>
                    </div>
                    {{-- BAGIAN KANAN: Badge --}}
                    @if (isset($verifikasiKhsCount) && $verifikasiKhsCount > 0)
                        <span class="badge bg-danger rounded-pill ms-2 d-flex align-items-center justify-content-center"
                            style="min-width: 24px; height: 24px; padding: 0;">
                            {{ $verifikasiKhsCount }}
                        </span>
                    @endif
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white {{ Request::is('dashboard-dosen/verifikasi-pkl') ? 'bg-gradient-primary' : '' }}"
                    href="/dashboard-dosen/verifikasi-pkl">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">work</i>
                    </div>
                    <span class="nav-link-text ms-1 text-wrap" style="line-height: 1.2;">Verifikasi Mahasiswa PKL</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white {{ Request::is('dashboard-dosen/verifikasi-skripsi') ? 'bg-gradient-primary' : '' }}"
                    href="/dashboard-dosen/verifikasi-skripsi">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">school</i>
                    </div>
                    <span class="nav-link-text ms-1 text-wrap" style="line-height: 1.2;">Verifikasi Mahasiswa
                        Skripsi</span>
                </a>
            </li>
            <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-8">
                    Account pages
                </h6>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" href="/logout">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">login</i>
                    </div>
                    <span class="nav-link-text ms-1">Log Out</span>
                </a>
            </li>
        </ul>
    </div>
    {{-- <div class="sidenav-footer  bottom-0">
        <div class="mx-3">
            <a class="btn bg-gradient-primary mt-4 w-100"
                href="https://www.creative-tim.com/product/material-dashboard-pro?ref=sidebarfree"
                type="button">Upgrade to pro</a>
        </div>
    </div> --}}
</aside>
