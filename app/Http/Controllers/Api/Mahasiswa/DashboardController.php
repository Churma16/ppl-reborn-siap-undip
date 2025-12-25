<?php

namespace App\Http\Controllers\Api\Mahasiswa;

use App\Enums\PklStatusKonfirmasi;
use App\Enums\SemesterStatusAktif;
use App\Enums\SkripsiStatusKonfirmasi;
use App\Http\Controllers\Controller;
use App\Http\Resources\DashboardResource;
use App\Models\IRS;
use App\Models\KHS;
use App\Models\Mahasiswa;
use App\Models\PKL;
use App\Models\Semester;
use App\Models\Skripsi;

class DashboardController extends Controller
{
    /**
    public function getMyProfile()
    {
        $myId = auth()->id();

        $myProfile['mahasiswa'] = Mahasiswa::with([
            'dosen',
        ])
        ->where('nim', $myId)->first();

        $myProfile['semester_aktif'] = IRS::where('mahasiswa_nim', $myId)->latest()->value('semester_aktif');

        $latestIpkAndSksk = KHS::where('mahasiswa_nim', $myId)->orderBy('semester', 'desc')->first(['ip_kumulatif', 'sks_kumulatif']);

        $statusPkl = PKL::where('mahasiswa_nim', $myId)->latest()->value('status_konfirmasi');
        $statusPkl = ($statusPkl) ? $statusPkl : PklStatusKonfirmasi::Belum_Ambil->label();

        $statusSkripsi = Skripsi::where('mahasiswa_nim', $myId)->latest()->value('status_konfirmasi');
        $statusSkripsi = ($statusSkripsi) ? $statusSkripsi : SkripsiStatusKonfirmasi::Belum_Ambil->label();

        $myProfile['rekap_akademik'] = [
            'ipk' => $latestIpkAndSksk->ip_kumulatif,
            'sks_kumulatif' => $latestIpkAndSksk->sks_kumulatif,
            'status_pkl' => $statusPkl,
            'status_skripsi' => $statusSkripsi,
        ];

        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil Mengambil Data Dashboard.',
            'data' => $myProfile,
            // 'latestIpkAndSksk'=>$latestIpkAndSksk,
        ],);
    }
     */
    public function getMyProfile()
    {
        $myId = auth()->id();

        $mahasiswa = Mahasiswa::with(['dosen', 'irsAktif', 'khs', 'pkl', 'skripsi'])
        ->where('nim', $myId)
        ->firstOrFail();

        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil Mengambil Data Dashboard.',
            'data' => new DashboardResource($mahasiswa),
            // 'mahasiswa'=>$mahasiswa
        ]

        );
    }
}
