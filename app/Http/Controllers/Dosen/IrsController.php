<?php

namespace App\Http\Controllers\Dosen;

use App\Models\IRS;
use App\Models\Dosen;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Mahasiswa;

class IrsController extends Controller
{

    public function getIrsVerificationTable()
    {
        // Cek apakah user login memiliki relasi dosen
        $dosen = Dosen::where('nip', auth()->user()->nip_nim)->first();

        // Mengambil data mahasiswa perwalian dosen
        $mahasiswas = Mahasiswa::milikDosen($dosen)->get();

        // Mendapatkan daftar nim mahasiswa perwalian dosen
        $mahasiswa_perwalian = $dosen->getMahasiswaBimbinganAttribute();

        // Mengambil data IRS mahasiswa perwalian yang belum dikonfirmasi
        $irss = IRS::whereIn('mahasiswa_nim', $mahasiswa_perwalian)
            ->where('status_konfirmasi', 'Belum Dikonfirmasi')
            ->get();

        return view('dashboard-dosen.partials.verifikasi-irs-table', compact(['irss', 'mahasiswas', 'dosen']));
    }

    public function verifikasiIrs($id, $action)
    {
        // 1. Cari Data
        $irs = IRS::find($id);

        if (!$irs) {
            return response()->json(['message' => 'Data IRS tidak ditemukan.'], 404);
        }
        // return response()->json(['message' => $irs], 400);

        if (!in_array($action, ['approve', 'reject'])) {
            return response()->json(['message' => 'Aksi tidak valid.'], 400);
        }

        // 4. Update Status (Logika Inti)
        if ($action === 'approve') {
            $irs->status_konfirmasi = 'Dikonfirmasi'; // Pastikan string ini sesuai dengan ENUM di database Anda
        } elseif ($action === 'reject') {
            $irs->status_konfirmasi = 'Ditolak';
        }

        // 5. Simpan Perubahan
        $irs->save();

        // 6. Return Sukses
        return response()->json([
            'message' => 'Verifikasi IRS berhasil.',
            'data' => $irs // Opsional: kirim data balik jika perlu update UI parsial
        ], 200);
    }
}
