<?php

namespace App\Exports\Departemen;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class MahasiswaSkripsiExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    protected $mahasiswas;

    // Kita terima data dari Controller agar filter-nya sama
    public function __construct($mahasiswas)
    {
        $this->mahasiswas = $mahasiswas;
    }

    public function collection()
    {
        return $this->mahasiswas;
    }

    // Mengatur Header (Judul Kolom) di Excel
    public function headings(): array
    {
        return [
            'No',
            'NIM',
            'Nama Mahasiswa',
            'Angkatan',
            'Judul Skripsi',
            'Status Skripsi',
            'Tanggal Mulai',
            'Tanggal Selesai',
            'Bimbingan Terakhir',
            'Nilai',
            // 'Judul Laporan',
        ];
    }

    // Mengatur data apa saja yang masuk ke kolom
    public function map($mahasiswa): array
    {
        // Logika Status
        // $status = 'Belum Ambil';
        // if ($mahasiswa->pklTerakhir) {
        //     $status = $mahasiswa->pklTerakhir->status_lulus;
        // }

        static $no = 0;
        $no++;

        return [
            $no,
            $mahasiswa->nim,
            $mahasiswa->nama,
            $mahasiswa->angkatan,
            $mahasiswa->skripsiTerakhir->judul ?? '-',
            $mahasiswa->skripsiTerakhir->status_skripsi ?? '-',
            $mahasiswa->skripsiTerakhir->tanggal_mulai,
            $mahasiswa->skripsiTerakhir->tanggal_selesai ?? '-',
            $mahasiswa->skripsiTerakhir->created_at->format('Y-m-d') ?? '-',
            $mahasiswa->skripsiTerakhir->nilai ?? '-',
        ];
    }

    // Bold Header
    public function styles(Worksheet $sheet)
    {
        return [
            1    => ['font' => ['bold' => true]],
        ];
    }
}
