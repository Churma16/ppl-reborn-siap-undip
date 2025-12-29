<!DOCTYPE html>
<html>

<head>
    <title>Laporan Perwalian</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h2,
        .header h3 {
            margin: 0;
        }

        .meta-info {
            margin-bottom: 20px;
            width: 100%;
        }

        .meta-info td {
            padding: 3px;
        }

        /* Table Styling */
        .table-data {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        .table-data th,
        .table-data td {
            border: 1px solid #000;
            padding: 6px;
            text-align: left;
        }

        .table-data th {
            background-color: #f0f0f0;
            text-align: center;
        }

        /* Signature Layout */
        .signature-section {
            width: 100%;
            text-align: right;
            margin-top: 50px;
        }

        .signature-box {
            display: inline-block;
            width: 200px;
            text-align: center;
        }
    </style>
</head>

<body>

    {{-- KOP SURAT SEDERHANA --}}
    <div class="header">
        <h3>KEMENTERIAN PENDIDIKAN, KEBUDAYAAN, RISET, DAN TEKNOLOGI</h3>
        <h2>UNIVERSITAS DIPONEGORO</h2>
        <p>Jl. Prof. Sudarto, S.H., Tembalang, Semarang Kode Pos 50275</p>
        <hr>
        <h3 style="margin-top: 15px;">LAPORAN MONITORING STATUS MAHASISWA</h3>
        <p>Periode: Semester Ganjil 2025/2026</p>
    </div>

    {{-- INFO DOSEN --}}
    <table class="meta-info">
        <tr>
            <td width="120"><strong>Nama Dosen Wali</strong></td>
            <td width="10">:</td>
            <td>{{ $dosen->nama }}</td>
        </tr>
        <tr>
            <td><strong>NIP</strong></td>
            <td>:</td>
            <td>{{ $dosen->nip }}</td>
        </tr>
        <tr>
            <td><strong>Semester</strong></td>
            <td>:</td>
            <td>Ganjil 2025/2026</td> {{-- Bisa dibuat dinamis --}}
        </tr>
    </table>

    {{-- TABEL MAHASISWA --}}
    <table class="table-data">
        <thead>
            <tr>
                <th width="30">No</th>
                <th width="100">NIM</th>
                <th>Nama Mahasiswa</th>
                <th width="60">Angkatan</th>
                <th width="80">Status</th>
                <th width="80">IPK (Smt Lalu)</th> {{-- Tambahan Info Kinerja --}}
            </tr>
        </thead>
        <tbody>
            @forelse($mahasiswas as $mhs)
                {{-- Logika highlight baris: Merah jika Non-Aktif/Cuti --}}
                <tr style="{{ $mhs->status != 'Aktif' ? 'background-color: #ffe6e6;' : '' }}">
                    <td style="text-align: center;">{{ $loop->iteration }}</td>
                    <td>{{ $mhs->nim }}</td>
                    <td>{{ $mhs->nama }}</td>
                    <td style="text-align: center;">{{ $mhs->angkatan }}</td>
                    <td style="text-align: center;">
                        {{-- Cetak Tebal jika bermasalah --}}
                        @if ($mhs->status_akademik != 'Aktif')
                            <strong>{{ $mhs->status_akademik }}</strong>
                        @else
                            {{ $mhs->status_akademik }}
                        @endif
                    </td>
                    <td style="text-align: center;">{{ $mhs->khsTerakhir->ip_kumulatif??0}}</td> {{-- Contoh Data --}}
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center;">Tidak ada data.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- BAGIAN TANDA TANGAN DIGANTI --}}
    <div class="signature-section">
        <div class="signature-box">
            <p>Semarang, {{ $tanggal }}</p>
            <p>Mengetahui,</p>
            <p>Ketua Departemen Informatika</p>
            <br><br><br>
            <p><strong><u>Dr. Aris Sugiharto, S.Si., M.Kom.</u></strong></p> {{-- Contoh Nama Kaprodi --}}
        </div>
    </div>

</body>

</html>
