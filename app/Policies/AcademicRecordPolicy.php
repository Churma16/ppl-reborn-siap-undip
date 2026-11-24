<?php

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Database\Eloquent\Model;

class AcademicRecordPolicy
{
    use HandlesAuthorization;

    /**
     * Tentukan apakah user dapat melihat/mengunduh berkas dokumen akademik (IRS, KHS, PKL, Skripsi).
     */
    public function view(User $user, Model $record): bool
    {
        // 1. Role Capability: Staf (Admin & Departemen) memiliki akses penuh
        if (in_array($user->role, [UserRole::Admin, UserRole::Departemen], true)) {
            return true;
        }

        // 2. Resource Ownership: Mahasiswa hanya berhak atas berkas miliknya sendiri
        if ($user->role === UserRole::Mahasiswa) {
            return (string) $record->mahasiswa_nim === (string) $user->nip_nim;
        }

        // 3. Advisory Relationship: Dosen hanya berhak atas berkas mahasiswa perwaliannya
        if ($user->role === UserRole::Dosen) {
            $dosen = $user->dosen;
            return $dosen && $record->mahasiswa && $record->mahasiswa->dosen_kode_wali === $dosen->kode_wali;
        }

        return false;
    }
}
