<?php

namespace App\Exports\Departemen;

use App\Models\Mahasiswa;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class MahasiswaPKLExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
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
            'Nama Instansi',
            'Status PKL',
            'Tanggal Mulai',
            'Tanggal Selesai',
            'Bimbingan Terakhir',
            'Nilai',
        ];
    }

    // Mengatur data apa saja yang masuk ke kolom
    public function map($mahasiswa): array
    {
        static $no = 0;
        $no++;

        return [
            $no,
            $mahasiswa->nim,
            $mahasiswa->nama,
            $mahasiswa->angkatan,
            $mahasiswa->pklTerakhir->nama_perusahaan ?? '-',
            $mahasiswa->pklTerakhir->status_lulus ?? '-',
            $mahasiswa->pklTerakhir->tanggal_mulai,
            $mahasiswa->pklTerakhir->tanggal_selesai ?? '-',
            $mahasiswa->pklTerakhir->created_at->format('Y-m-d') ?? '-',
            $mahasiswa->pklTerakhir->nilai_angka ?? '-',
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
