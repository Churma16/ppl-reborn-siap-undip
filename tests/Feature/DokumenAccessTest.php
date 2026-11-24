<?php

namespace Tests\Feature;

use App\Enums\UserRole;
use App\Models\Dosen;
use App\Models\IRS;
use App\Models\Mahasiswa;
use App\Models\Semester;
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
}
