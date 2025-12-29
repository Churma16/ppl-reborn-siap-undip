<?php

namespace App\Http\Controllers\Dosen;

use App\Models\IRS;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IrsController extends Controller
{
    public function index()
    {
        $dosen = Dosen::where('nip', auth()->user()->nip_nim)->first();

        $mahasiswas = Mahasiswa::milikDosen($dosen)->get();

        // Mendapatkan daftar nim mahasiswa perwalian dosen
        $mahasiswa_perwalian = $dosen->getMahasiswaBimbinganAttribute();

        // Mengambil data IRS mahasiswa perwalian yang belum dikonfirmasi
        $irss = IRS::whereIn('mahasiswa_nim', $mahasiswa_perwalian)
            ->where('status_konfirmasi', 'Belum Dikonfirmasi')
            ->get();

        return view('dashboard-dosen.verifikasi-irs-mahasiswa', [
            'title' => 'Verifikasi IRS',
            'mahasiswas' => $mahasiswas,
            'dosen' => $dosen,
            'irss' => $irss,
        ]);
    }

    public function getIrsVerificationTable()
    {
        $dosen = auth()->user()->dosen;
        $irss = IRS::belumDikonfirmasi()->milikDosen($dosen->kode_wali)
            ->with(['mahasiswa', 'semester'])
            ->get();

        return view('dashboard-dosen.partials.verifikasi-irs-table', compact('irss'));
    }

    public function verifikasiIrs($id, $action)
    {

        $irs = IRS::find($id);

        if (!$irs) {
            return response()->json(['message' => 'Data IRS tidak ditemukan.'], 404);
        }


        if (!in_array($action, ['approve', 'reject'])) {
            return response()->json(['message' => 'Aksi tidak valid.'], 400);
        }


        if ($action === 'approve') {
            $irs->status_konfirmasi = 'Dikonfirmasi';
        } elseif ($action === 'reject') {
            $irs->status_konfirmasi = 'Ditolak';
        }

        // 5. Simpan Perubahan
        $irs->save();

        // 6. Return Sukses
        return response()->json([
            'message' => 'Verifikasi IRS berhasil.',
            'data' => $irs
        ], 200);
    }
}
