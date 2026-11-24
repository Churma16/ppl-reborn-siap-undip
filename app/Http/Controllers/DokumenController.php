<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Models\IRS;
use App\Models\KHS;
use App\Models\PKL;
use App\Models\Skripsi;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DokumenController extends Controller
{
    /**
     * Tampilkan atau unduh dokumen akademik terproteksi (IRS, KHS, PKL, Skripsi).
     */
    public function show(string $type, int $id)
    {
        $user = auth()->user();
        if (!$user) {
            abort(401, 'Silakan login terlebih dahulu.');
        }

        $record = match (strtolower($type)) {
            'irs' => IRS::with('mahasiswa')->findOrFail($id),
            'khs' => KHS::with('mahasiswa')->findOrFail($id),
            'pkl' => PKL::with('mahasiswa')->findOrFail($id),
            'skripsi' => Skripsi::with('mahasiswa')->findOrFail($id),
            default => abort(404, 'Tipe dokumen tidak valid.'),
        };

        $filePath = match (strtolower($type)) {
            'irs' => $record->file_sks,
            'khs' => $record->file_khs,
            'pkl' => $record->file_pkl,
            'skripsi' => $record->file_skripsi,
        };

        if (!$filePath) {
            abort(404, 'Dokumen belum diunggah.');
        }

        // Verifikasi Otorisasi:
        // 1. Staf (Admin & Departemen): diizinkan
        // 2. Mahasiswa: hanya pemilik berkas (NIM cocok)
        // 3. Dosen: hanya mahasiswa perwalian (dosen_kode_wali cocok)
        $isStaff = in_array($user->role, [UserRole::Admin, UserRole::Departemen], true);
        $isOwner = (string) $record->mahasiswa_nim === (string) $user->nip_nim;
        $isDoswal = false;

        if ($user->role === UserRole::Dosen) {
            $dosen = $user->dosen;
            if ($dosen && $record->mahasiswa && $record->mahasiswa->dosen_kode_wali === $dosen->kode_wali) {
                $isDoswal = true;
            }
        }

        if (!$isStaff && !$isOwner && !$isDoswal) {
            abort(403, 'Anda tidak memiliki hak akses untuk melihat dokumen ini.');
        }

        // Jika berkas berupa URL eksternal, alihkan SETELAH lolos otorisasi
        if (Str::startsWith($filePath, 'http://') || Str::startsWith($filePath, 'https://')) {
            return redirect()->away($filePath);
        }

        // Layani dari disk 'local' (privat) atau 'public' (kompatibilitas berkas lama)
        if (Storage::disk('local')->exists($filePath)) {
            return Storage::disk('local')->response($filePath);
        }

        if (Storage::disk('public')->exists($filePath)) {
            return Storage::disk('public')->response($filePath);
        }

        abort(404, 'Berkas fisik dokumen tidak ditemukan di server.');
    }
}
