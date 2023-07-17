<aside
    class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3 bg-gradient-dark"
    id="sidenav-main">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-white opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
            aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand m-0" href=" https://demos.creative-tim.com/material-dashboard/pages/dashboard "
            target="_blank">
            <img src="/img/logo-undip.png" class="navbar-brand-img h-100" alt="main_logo" />
            <span class="ms-1 font-weight-bold text-white">SIAP UNDIP</span>
        </a>
    </div>
    <hr class="horizontal light mt-0 mb-2" />
    <div class="collapse navbar-collapse w-auto" id="sidenav-collapse-main">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link text-white {{ Request::is('dashboard-mahasiswa') ? 'bg-gradient-primary' : '' }} "
                    href="/dashboard-mahasiswa">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">dashboard</i>
                    </div>
                    <span class="nav-link-text ms-1">Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white {{ Request::is('dashboard-mahasiswa/kelola-irs*') ? 'bg-gradient-primary' : '' }}"
                    href="/dashboard-mahasiswa/kelola-irs">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">description</i>
                    </div>
                    <span class="nav-link-text ms-1">Isian Rencana Studi (IRS)</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white {{ Request::is('dashboard-mahasiswa/kelola-khs*') ? 'bg-gradient-primary' : '' }}"
                    href="/dashboard-mahasiswa/kelola-khs">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">menu_book</i>
                    </div>
                    <span class="nav-link-text ms-1">Kartu Hasil Studi (KHS)</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white {{ Request::is('dashboard-mahasiswa/kelola-pkl') ? 'bg-gradient-primary' : '' }}"
                    href="/dashboard-mahasiswa/kelola-pkl">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">badge</i>
                    </div>
                    <span class="nav-link-text ms-1">Praktek Kerja Lapangan (PKL)</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white {{ Request::is('dashboard-mahasiswa/kelola-skripsi') ? 'bg-gradient-primary' : '' }}"
                    href="/dashboard-mahasiswa/kelola-skripsi">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">history_edu</i>
                    </div>
                    <span class="nav-link-text ms-1">Skripsi</span>
                </a>
            </li>
            <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-8">
                    Account pages
                </h6>
            </li>
            <li class="nav-item ">
                <a class="nav-link text-white {{ Request::is('dashboard-mahasiswa/edit-profile') ? 'bg-gradient-primary' : '' }}" href="/dashboard-mahasiswa/edit-profile" {{ Request::is('dashboard-mahasiswa/edit-profile') ? 'bg-gradient-primary' : '' }}>
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">edit_note</i>
                    </div>
                    <span class="nav-link-text ms-1">Edit Profile</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" href="/logout">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">logout</i>
                    </div>
                    <span class="nav-link-text ms-1">Log Out</span>
                </a>
            </li>
        </ul>
    </div>
    <div class="sidenav-footer position-absolute w-100 bottom-0">
        <div class="mx-3">
            <a class="btn bg-gradient-primary mt-4 w-100"
                href="https://www.creative-tim.com/product/material-dashboard-pro?ref=sidebarfree"
                type="button">Upgrade to pro</a>
        </div>
    </div>
</aside>
