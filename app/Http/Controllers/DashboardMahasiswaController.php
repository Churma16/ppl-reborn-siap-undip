<?php

namespace App\Http\Controllers;

use App\Enums\SkripsiStatusKonfirmasi;
use App\Models\IRS;
use App\Models\Kabupaten;
use App\Models\KHS;
use App\Models\Mahasiswa;
use App\Models\PKL;
use App\Models\Provinsi;
use App\Models\Semester;
use App\Models\Skripsi;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardMahasiswaController extends Controller
{
    /**
     * Menampilkan halaman utama dashboard mahasiswa.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        // Mendapatkan data mahasiswa berdasarkan NIM pengguna yang sedang login
        $mahasiswa = Mahasiswa::where('nim', auth()->user()->nip_nim)->first();

        // Menghitung IPK kumulatif
        $ipKumulatifNotFormatted = number_format(KHS::where('mahasiswa_nim', $mahasiswa->nim)
            ->where('status_konfirmasi', 'Dikonfirmasi')
            ->avg('ip_semester'), 2);
        $ipk = $ipKumulatifNotFormatted;

        $ipkSmtBefore = KHS::where('mahasiswa_nim', $mahasiswa->nim)
            ->where('status_konfirmasi', 'Dikonfirmasi')
            ->skip(1)
            ->take(1)
            ->value('ip_kumulatif');

        // dd($ipkSmtBefore);
        // Mendapatkan semester aktif terakhir
        $semesterAktif = IRS::where('mahasiswa_nim', $mahasiswa->nim)
            ->orderBy('semester_aktif', 'desc')
            ->first();
        if ($semesterAktif == null) {
            $semesterAktif = [
                'semester_aktif' => '-',
            ];
        }

        $ipkDiff = ($ipk - $ipkSmtBefore);
        $ipkDiff = $ipkDiff.($ipkDiff > 0 ? '▲' : '▼');

        $ipPerSmt = KHS::where('mahasiswa_nim', $mahasiswa->nim)
        ->orderBy('semester', 'asc')
        ->pluck('ip_semester', 'semester');

        $ipkPerSmt = KHS::where('mahasiswa_nim', $mahasiswa->nim)
        ->orderBy('semester', 'asc')
        ->pluck('ip_kumulatif', 'semester');
        // dd($ipPerSmt->keys());

        // Menghitung SKS kumulatif
        $sksk = IRS::where('mahasiswa_nim', $mahasiswa->nim)
            ->where('status_konfirmasi', 'Dikonfirmasi')
            ->sum('jumlah_sks');

        $skskSmtBefore = IRS::where('mahasiswa_nim', $mahasiswa->nim)
            ->where('status_konfirmasi', 'Dikonfirmasi')
            ->where('semester_aktif', '<=', $semesterAktif['semester_aktif'])
            ->orderBy('semester_aktif', 'desc')
            ->take(1)
            ->value('jumlah_sks').'▲';

        // $tglSmtAktif = IRS::where('mahasiswa_nim', $mahasiswa->nim)
        //     ->join('semesters', 'i_r_s.semester_id', '=', 'semesters.id')
        //     ->orderBy('semesters.tanggal_selesai', 'asc')
        //     // ->select('i_r_s.*')
        //     ->take(1)
        //     ->value('semesters.tanggal_selesai');

        $tglSmtAktif = SEMESTER::whereHas('irs', fn ($q) => $q
        ->where('mahasiswa_nim', $mahasiswa->nim)
        )
        ->orderBy('tanggal_selesai', 'asc')
        ->value('tanggal_selesai');

        // dd($tglSmtAktif);
        $countdownSemester = Carbon::parse($tglSmtAktif)->diffInDays(Carbon::now());
        $khsSmtLatest = KHS::where('mahasiswa_nim', $mahasiswa->nim)
        ->latest()
        ->first();

        $irsSmtLatest = IRS::where('mahasiswa_nim', $mahasiswa->nim)
        ->latest()
        ->first();

        $skripsiSmtLatest = Skripsi::where('mahasiswa_nim', $mahasiswa->nim)
        ->latest()
        ->first();

        $pklSmtLatest = PKL::where('mahasiswa_nim', $mahasiswa->nim)
        ->latest()
        ->first();

        $statusSkripsi = $skripsiSmtLatest?->status_konfirmasi ?? SkripsiStatusKonfirmasi::Belum_Ambil;
        $statusPkl = $pklSmtLatest?->status_konfirmasi ?? SkripsiStatusKonfirmasi::Belum_Ambil;

        $steps = [
            'Pengajuan Judul',
            'Bimbingan Proposal',
            'Seminar Proposal',
            'Bimbingan Skripsi',
            'Sidang Akhir',
            'Lulus',
        ];

        $currentStepIndex = 3; // Misalnya, langkah saat ini adalah "Bimbingan Skripsi"
        // dd($khsSmtLatest);
        return view('dashboard-mahasiswa.index', [
            'title' => 'Dashboard Mahasiswa',
            'mahasiswa' => $mahasiswa,
            'ipk' => $ipk,
            'semesterAktif' => $semesterAktif['semester_aktif'],
            'sksk' => $sksk,
            'ipkDiff' => $ipkDiff,
            'skskSmtBefore' => $skskSmtBefore,
            'ipPerSmt' => $ipPerSmt,
            'ipkPerSmt' => $ipkPerSmt,
            'countdownSemester' => $countdownSemester,
            'khsSmtLatest' => $khsSmtLatest,
            'irsSmtLatest' => $irsSmtLatest,
            'statusSkripsi' => $statusSkripsi,
            'statusPkl' => $statusPkl,
            'steps' => $steps,
            'currentStepIndex' => $currentStepIndex,
        ]);
    }

    /**
     * Menampilkan halaman edit profil mahasiswa.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function edit()
    {
        $mahasiswa = Mahasiswa::where('nim', auth()->user()->nip_nim)->first();
        $provinsis = Provinsi::all();
        $kabupaten = Kabupaten::all();

        return view('dashboard-mahasiswa.edit-profile', [
            'title' => 'Edit Profil',
            'mahasiswa' => $mahasiswa,
            'provinsis' => $provinsis,
            'kabupaten' => $kabupaten,
        ]);
    }

    /**
     * Mengambil data kabupaten berdasarkan kode provinsi.
     *
     * @param  string  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function fetchKabupaten($id)
    {
        $kabupatens = Kabupaten::where('provinsi_kode_provinsi', $id)->get(['kode_kabupaten', 'nama']);

        return response()->json($kabupatens);
    }

    /**
     * Memperbarui profil mahasiswa.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Mahasiswa $mahasiswa, Request $request)
    {
        // Validasi data input
        $validatedData = $request->validate([
            'no_hp' => 'required|numeric',
            'email' => 'required|email',
            'alamat' => 'required',
            'kabupaten' => 'required',
            'provinsi' => 'required',
        ]);

        // Mengganti nama kolom dalam array $validatedData
        $validatedData['kabupaten_kode_kabupaten'] = $validatedData['kabupaten'];
        unset($validatedData['kabupaten']);

        $validatedData['provinsi_kode_provinsi'] = $validatedData['provinsi'];
        unset($validatedData['provinsi']);

        // Memperbarui data mahasiswa
        Mahasiswa::where('nim', auth()->user()->nip_nim)->update($validatedData);

        return redirect('/dashboard-mahasiswa')->with('success', 'New post has been added!');
    }
}
