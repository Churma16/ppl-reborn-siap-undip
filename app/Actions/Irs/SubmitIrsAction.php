<?php

namespace App\Actions\Irs;

use App\Enums\IrsStatusKonfirmasi;
use App\Enums\SemesterStatusAktif;
use App\Models\IRS;
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
        $path = $file->storeAs('file-sks', $fileName, 'local');
        $payload['file_sks'] = $path;

        // $irs = new Irs(
        //     $payload, );


        // return $irs;

        return IRS::create($payload);

    }
}
