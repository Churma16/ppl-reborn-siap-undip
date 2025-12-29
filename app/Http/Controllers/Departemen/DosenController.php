<?php

namespace App\Http\Controllers\Departemen;

use App\Models\Dosen;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;

class DosenController extends Controller
{

    public function index()
    {
        $dosens = Dosen::with('mahasiswa')->withCount('mahasiswa')->get();
        // dd($dosens);P
        return view('dashboard-departemen.dosen.index', [
            'title' => 'Data Dosen',
            'dosens' => $dosens,
        ]);
    }

    public function cetakPdfPerwalian($nip)
    {
        // 1. Ambil data dosen beserta mahasiswanya
        $dosen = Dosen::with('mahasiswa')->where('nip', $nip)->firstOrFail();

        // 2. Siapkan data untuk dikirim ke view PDF
        $data = [
            'dosen' => $dosen,
            'mahasiswas' => $dosen->mahasiswa,
            'tanggal' => now()->translatedFormat('d F Y'), // Format tanggal Indonesia
        ];

        // 3. Load View PDF (Kita akan buat file ini di langkah selanjutnya)
        $pdf = Pdf::loadView('dashboard-departemen.cetak.perwalian_pdf_departemen', $data);

        // 4. Set ukuran kertas dan orientasi (A4, Portrait)
        $pdf->setPaper('a4', 'portrait');

        // 5. Stream (Tampilkan di browser) alih-alih langsung download
        return $pdf->stream('Laporan_Perwalian_' . $dosen->nama . '.pdf');
    }


}
