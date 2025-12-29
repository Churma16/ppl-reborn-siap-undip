<?php

namespace App\Http\Controllers\Dosen;

use App\Models\KHS;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class KhsController extends Controller
{

    public function index()
    {
        // Mengambil data dosen berdasarkan NIP pengguna yang sedang login
        $dosen = auth()->user()->dosen;

        // Mengambil data mahasiswa perwalian dosen
        $mahasiswas = Mahasiswa::milikDosen($dosen)->get();

        // Mendapatkan daftar nim mahasiswa perwalian dosen
        $mahasiswa_perwalian = $dosen->getMahasiswaBimbinganAttribute();

        // Mengambil data KHS mahasiswa perwalian yang belum dikonfirmasi
        $khss = KHS::whereIn('mahasiswa_nim', $mahasiswa_perwalian)
            ->where('status_konfirmasi', 'Belum Dikonfirmasi')
            ->get();

        return view('dashboard-dosen.verifikasi-khs-mahasiswa', [
            'title' => 'Verifikasi KHS',
            'mahasiswas' => $mahasiswas,
            'dosen' => $dosen,
            'khss' => $khss,
        ]);
    }
    public function getKhsVerificationTable()
    {
        $dosen = auth()->user()->dosen;
        $khss = KHS::belumDikonfirmasi()->milikDosen($dosen->kode_wali)
            ->with(['mahasiswa', 'semester'])
            ->get();

        return view('dashboard-dosen.partials.verifikasi-khs-table', compact('khss'));
    }

    public function verifikasiKhs($id, $action)
    {

        $khs = KHS::find($id);

        if (!$khs) {
            return response()->json(['message' => 'Data KHS tidak ditemukan.'], 404);
        }


        if (!in_array($action, ['approve', 'reject'])) {
            return response()->json(['message' => 'Aksi tidak valid.'], 400);
        }


        if ($action === 'approve') {
            $khs->status_konfirmasi = 'Dikonfirmasi';
        } elseif ($action === 'reject') {
            $khs->status_konfirmasi = 'Ditolak';
        }

        // 5. Simpan Perubahan
        $khs->save();
        // 6. Return Sukses
        return response()->json([
            'message' => 'Verifikasi KHS berhasil.',
            'data' => $khs
        ], 200);
    }
}
