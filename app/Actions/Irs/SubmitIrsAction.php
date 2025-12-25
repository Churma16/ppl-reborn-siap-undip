<?php

namespace App\Actions\Irs;

use App\Enums\IrsStatusKonfirmasi;
use App\Enums\SemesterStatusAktif;
use App\Models\Irs;
use App\Models\KHS;
use App\Models\Semester;
use Illuminate\Http\UploadedFile;

class SubmitIrsAction
{
    public function execute(array $payload, UploadedFile $file, int $userId)
    {
        $payload['semester_aktif'] = KHS::where('mahasiswa_nim', $userId)
        ->latest()
        ->value('semester') + 1;

        $payload['mahasiswa_nim'] = $userId;

        $payload['semester_id'] = Semester::where('is_active', SemesterStatusAktif::AKTIF->value)->value('id');

        $payload['status_konfirmasi'] = IrsStatusKonfirmasi::Belum_Dikonfirmasi->value;

        $fileName = $file->hashName();
        $path = $file->storeAs('public/uploads/users/file-sks', $fileName);
        $dbPath = str_replace('public/', '', $path);
        $payload['file_sks'] = $dbPath;

        // $irs = new Irs(
        //     $payload, );


        // return $irs;

        return Irs::create($payload);

    }
}
