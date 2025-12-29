@foreach ($khss as $khs)
    <tr>
        {{-- 1. No --}}
        <td class="align-middle text-center">
            <span class="text-secondary text-xs font-weight-bold">{{ $loop->iteration }}</span>
        </td>

        {{-- 2. Mahasiswa --}}
        <td class="align-middle">
            <div class="d-flex px-2 py-1">
                <div>
                    <img src="{{ $khs->mahasiswa->foto_mahasiswa ?? asset('assets/img/default-avatar.png') }}"
                        class="avatar avatar-sm me-3 border-radius-lg" alt="foto">
                </div>
                <div class="d-flex flex-column justify-content-center">
                    <h6 class="mb-0 text-sm">{{ $khs->mahasiswa->nama }}</h6>
                </div>
            </div>
        </td>

        {{-- 3. NIM --}}
        <td class="align-middle">
            <span class="text-secondary text-xs font-weight-bold">{{ $khs->mahasiswa->nim }}</span>
        </td>

        {{-- 4. Angkatan --}}
        <td class="align-middle text-center">
            <span class="text-secondary text-xs font-weight-bold">{{ $khs->mahasiswa->angkatan }}</span>
        </td>

        {{-- 5. Smt --}}
        <td class="align-middle text-center">
            <span class="text-secondary text-xs font-weight-bold">{{ $khs->semester }}</span>
        </td>

        {{-- 6. ip semester --}}
        <td class="align-middle text-center">
            <span class="text-dark text-xs font-weight-bold">{{ $khs->ip_semester ?? '-' }}</span>
        </td>

        {{-- 7. Berkas --}}
        <td class="align-middle text-center">
            @if ($khs->file_khs)
                <a href="{{ $khs->file_khs }}" target="_blank" class="btn btn-outline-info btn-sm mb-0 p-1 px-3">
                    <i class="fas fa-file-pdf me-1"></i> Lihat
                </a>
            @else
                <span class="text-xs text-secondary">N/A</span>
            @endif
        </td>

        {{-- 8. Aksi --}}
        <td class="align-middle text-center">
            <a href="javascript:void(0)" onclick="handleValidation({{ $khs->id }}, 'approve')"
                class="btn btn-outline-success btn-sm px-2 py-1 mb-0" title="Setujui">
                <i class="material-icons text-sm">check</i>
            </a>
            <a href="javascript:void(0)" onclick="handleValidation({{ $khs->id }}, 'reject')"
                class="btn btn-outline-danger btn-sm px-2 py-1 mb-0" title="Tolak">
                <i class="material-icons text-sm">close</i>
            </a>
        </td>
    </tr>
@endforeach
{{-- HAPUS @EMPTY DI SINI. BIARKAN KOSONG JIKA TIDAK ADA DATA --}}

