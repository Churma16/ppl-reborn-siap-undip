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
        <h3 style="margin-top: 15px;">BERITA ACARA PERWALIAN</h3>
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
                <th width="80">Paraf Mhs</th>
            </tr>
        </thead>
        <tbody>
            @forelse($mahasiswas as $mhs)
                <tr>
                    <td style="text-align: center;">{{ $loop->iteration }}</td>
                    <td>{{ $mhs->nim }}</td>
                    <td>{{ $mhs->nama }}</td>
                    <td style="text-align: center;">{{ $mhs->angkatan }}</td>
                    <td style="text-align: center;">{{ $mhs->status }}</td>
                    <td></td> {{-- Kolom kosong untuk tanda tangan --}}
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center;">Tidak ada data mahasiswa perwalian.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- TANDA TANGAN --}}
    <div class="signature-section">
        <div class="signature-box">
            <p>Semarang, {{ $tanggal }}</p>
            <p>Dosen Wali,</p>
            <br><br><br>
            <p><strong><u>{{ $dosen->nama }}</u></strong></p>
            <p>NIP. {{ $dosen->nip }}</p>
        </div>
    </div>

</body>

</html>
