<?php

namespace Tests\Feature;

use App\Enums\UserRole;
use App\Models\Dosen;
use App\Models\IRS;
use App\Models\KHS;
use App\Models\Mahasiswa;
use App\Models\PKL;
use App\Models\Semester;
use App\Models\Skripsi;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class DokumenAccessTest extends TestCase
{
    use RefreshDatabase;

    private User $studentUser;
    private User $otherStudentUser;
    private User $doswalUser;
    private User $otherDosenUser;
    private User $deptUser;
    private User $adminUser;
    private IRS $irs;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('local');
        Storage::fake('public');

        // Semester
        $semester = Semester::create([
            'nama_semester' => '2025/2026 Ganjil',
            'kode_semester' => '20251',
            'is_active' => true,
            'tanggal_mulai' => '2025-08-01',
            'tanggal_selesai' => '2025-12-31',
        ]);

        // Dosen 1 (Doswal)
        $this->doswalUser = User::create([
            'username' => 'dosen1',
            'nip_nim' => '198001012005011001',
            'password' => bcrypt('password'),
            'role' => UserRole::Dosen,
        ]);
        Dosen::create([
            'nip' => '198001012005011001',
            'nama' => 'Dr. Budi Santoso',
            'kode_wali' => 'DW01',
            'email' => 'budi@undip.ac.id',
            'no_hp' => '081234567890',
            'alamat' => 'Semarang',
        ]);

        // Dosen 2 (Dosen Lain)
        $this->otherDosenUser = User::create([
            'username' => 'dosen2',
            'nip_nim' => '198502022008012002',
            'password' => bcrypt('password'),
            'role' => UserRole::Dosen,
        ]);
        Dosen::create([
            'nip' => '198502022008012002',
            'nama' => 'Dr. Siti Aminah',
            'kode_wali' => 'DW02',
            'email' => 'siti@undip.ac.id',
            'no_hp' => '081234567891',
            'alamat' => 'Semarang',
        ]);

        // Mahasiswa 1 (Pemilik Berkas)
        $this->studentUser = User::create([
            'username' => 'mhs1',
            'nip_nim' => '24060120120001',
            'password' => bcrypt('password'),
            'role' => UserRole::Mahasiswa,
        ]);
        Mahasiswa::create([
            'nim' => '24060120120001',
            'nama' => 'Ahmad Faiz',
            'dosen_kode_wali' => 'DW01',
            'angkatan' => 2020,
            'email' => 'faiz@students.undip.ac.id',
            'jalur_masuk' => 'SNMPTN',
        ]);

        // Mahasiswa 2 (Mahasiswa Lain)
        $this->otherStudentUser = User::create([
            'username' => 'mhs2',
            'nip_nim' => '24060120120002',
            'password' => bcrypt('password'),
            'role' => UserRole::Mahasiswa,
        ]);
        Mahasiswa::create([
            'nim' => '24060120120002',
            'nama' => 'Dewi Lestari',
            'dosen_kode_wali' => 'DW02',
            'angkatan' => 2020,
            'email' => 'dewi@students.undip.ac.id',
            'jalur_masuk' => 'SBMPTN',
        ]);

        // User Departemen
        $this->deptUser = User::create([
            'username' => 'dept1',
            'nip_nim' => '197503032000031001',
            'password' => bcrypt('password'),
            'role' => UserRole::Departemen,
        ]);

        // User Admin
        $this->adminUser = User::create([
            'username' => 'admin1',
            'nip_nim' => '197001012000011001',
            'password' => bcrypt('password'),
            'role' => UserRole::Admin,
        ]);

        // Berkas pada disk 'local'
        Storage::disk('local')->put('file-sks/test-irs.pdf', '%PDF-1.4 Fake PDF Content');

        // IRS Mahasiswa 1
        $this->irs = IRS::create([
            'semester_aktif' => 5,
            'status_konfirmasi' => 'Belum Dikonfirmasi',
            'jumlah_sks' => 20,
            'file_sks' => 'file-sks/test-irs.pdf',
            'mahasiswa_nim' => '24060120120001',
            'semester_id' => $semester->id,
        ]);
    }

    public function test_unauthenticated_guest_is_redirected_to_login()
    {
        $response = $this->get(route('dokumen.show', ['type' => 'irs', 'id' => $this->irs->id]));
        $response->assertRedirect('/login');
    }

    public function test_owner_student_can_view_own_document()
    {
        $response = $this->actingAs($this->studentUser)
            ->get(route('dokumen.show', ['type' => 'irs', 'id' => $this->irs->id]));

        $response->assertOk();
    }

    public function test_peer_student_cannot_view_other_student_document()
    {
        $response = $this->actingAs($this->otherStudentUser)
            ->get(route('dokumen.show', ['type' => 'irs', 'id' => $this->irs->id]));

        $response->assertForbidden();
    }

    public function test_advising_lecturer_can_view_advisee_document()
    {
        $response = $this->actingAs($this->doswalUser)
            ->get(route('dokumen.show', ['type' => 'irs', 'id' => $this->irs->id]));

        $response->assertOk();
    }

    public function test_non_advising_lecturer_cannot_view_other_lecturer_advisee_document()
    {
        $response = $this->actingAs($this->otherDosenUser)
            ->get(route('dokumen.show', ['type' => 'irs', 'id' => $this->irs->id]));

        $response->assertForbidden();
    }

    public function test_department_staff_can_view_any_document()
    {
        $response = $this->actingAs($this->deptUser)
            ->get(route('dokumen.show', ['type' => 'irs', 'id' => $this->irs->id]));

        $response->assertOk();
    }

    public function test_admin_staff_can_view_any_document()
    {
        $response = $this->actingAs($this->adminUser)
            ->get(route('dokumen.show', ['type' => 'irs', 'id' => $this->irs->id]));

        $response->assertOk();
    }

    public function test_missing_document_returns_404()
    {
        $response = $this->actingAs($this->adminUser)
            ->get(route('dokumen.show', ['type' => 'irs', 'id' => 99999]));

        $response->assertNotFound();
    }

    public function test_invalid_type_returns_404()
    {
        $response = $this->actingAs($this->adminUser)
            ->get(route('dokumen.show', ['type' => 'invalid', 'id' => $this->irs->id]));

        $response->assertNotFound();
    }

    public function test_non_numeric_id_returns_404()
    {
        $response = $this->actingAs($this->adminUser)
            ->get('/dokumen/irs/undefined');

        $response->assertNotFound();
    }

    public function test_external_url_document_is_blocked_for_unauthorized_users()
    {
        $semester = Semester::first();
        $extIrs = IRS::create([
            'semester_aktif' => 6,
            'status_konfirmasi' => 'Belum Dikonfirmasi',
            'jumlah_sks' => 22,
            'file_sks' => 'https://external-storage.example.com/confidential-irs.pdf',
            'mahasiswa_nim' => '24060120120001',
            'semester_id' => $semester->id,
        ]);

        // Mahasiswa lain dilarang (403), BUKAN di-redirect ke URL eksternal (302)
        $this->actingAs($this->otherStudentUser)
            ->get(route('dokumen.show', ['type' => 'irs', 'id' => $extIrs->id]))
            ->assertForbidden();

        // Pemilik sah di-redirect ke URL eksternal setelah lolos otorisasi
        $this->actingAs($this->studentUser)
            ->get(route('dokumen.show', ['type' => 'irs', 'id' => $extIrs->id]))
            ->assertRedirect('https://external-storage.example.com/confidential-irs.pdf');
    }

    public function test_khs_document_access_control()
    {
        Storage::disk('local')->put('file-khs/test-khs.pdf', '%PDF-1.4 Fake KHS');
        $semester = Semester::first();

        $khs = KHS::create([
            'semester' => 4,
            'status_konfirmasi' => 'Belum Dikonfirmasi',
            'sks_semester' => 20,
            'sks_kumulatif' => 80,
            'ip_semester' => 3.80,
            'ip_kumulatif' => 3.75,
            'status_mahasiswa' => 'Aktif',
            'file_khs' => 'file-khs/test-khs.pdf',
            'mahasiswa_nim' => '24060120120001',
            'semester_id' => $semester->id,
        ]);

        // Pemilik sah -> 200
        $this->actingAs($this->studentUser)
            ->get(route('dokumen.show', ['type' => 'khs', 'id' => $khs->id]))
            ->assertOk();

        // Mahasiswa lain -> 403
        $this->actingAs($this->otherStudentUser)
            ->get(route('dokumen.show', ['type' => 'khs', 'id' => $khs->id]))
            ->assertForbidden();

        // Dosen wali -> 200
        $this->actingAs($this->doswalUser)
            ->get(route('dokumen.show', ['type' => 'khs', 'id' => $khs->id]))
            ->assertOk();

        // Dosen bukan wali -> 403
        $this->actingAs($this->otherDosenUser)
            ->get(route('dokumen.show', ['type' => 'khs', 'id' => $khs->id]))
            ->assertForbidden();
    }

    public function test_pkl_document_access_control()
    {
        Storage::disk('local')->put('file-pkl/test-pkl.pdf', '%PDF-1.4 Fake PKL');
        $semester = Semester::first();

        $pkl = PKL::create([
            'status_konfirmasi' => 'Belum Dikonfirmasi',
            'status_lulus' => 'Belum Lulus',
            'tanggal_mulai' => '2025-09-01',
            'nama_perusahaan' => 'Tech Corp',
            'rincian_progress' => 'Laporan Akhir',
            'progress_ke' => 1,
            'file_pkl' => 'file-pkl/test-pkl.pdf',
            'mahasiswa_nim' => '24060120120001',
            'semester_id' => $semester->id,
        ]);

        // Pemilik sah -> 200
        $this->actingAs($this->studentUser)
            ->get(route('dokumen.show', ['type' => 'pkl', 'id' => $pkl->id]))
            ->assertOk();

        // Mahasiswa lain -> 403
        $this->actingAs($this->otherStudentUser)
            ->get(route('dokumen.show', ['type' => 'pkl', 'id' => $pkl->id]))
            ->assertForbidden();

        // Dosen wali -> 200
        $this->actingAs($this->doswalUser)
            ->get(route('dokumen.show', ['type' => 'pkl', 'id' => $pkl->id]))
            ->assertOk();
    }

    public function test_skripsi_document_access_control()
    {
        Storage::disk('local')->put('file_skripsi/test-skripsi.pdf', '%PDF-1.4 Fake Skripsi');
        $semester = Semester::first();

        $skripsi = Skripsi::create([
            'judul' => 'Sistem Informasi Akademik',
            'status_konfirmasi' => 'Belum Dikonfirmasi',
            'status_skripsi' => 'Belum Lulus',
            'tanggal_mulai' => '2025-09-01',
            'rincian_progress' => 'Bab 1',
            'progress_ke' => 1,
            'file_skripsi' => 'file_skripsi/test-skripsi.pdf',
            'mahasiswa_nim' => '24060120120001',
            'semester_id' => $semester->id,
        ]);

        // Pemilik sah -> 200
        $this->actingAs($this->studentUser)
            ->get(route('dokumen.show', ['type' => 'skripsi', 'id' => $skripsi->id]))
            ->assertOk();

        // Mahasiswa lain -> 403
        $this->actingAs($this->otherStudentUser)
            ->get(route('dokumen.show', ['type' => 'skripsi', 'id' => $skripsi->id]))
            ->assertForbidden();

        // Dosen wali -> 200
        $this->actingAs($this->doswalUser)
            ->get(route('dokumen.show', ['type' => 'skripsi', 'id' => $skripsi->id]))
            ->assertOk();
    }
}
