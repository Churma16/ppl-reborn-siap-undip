<?php

namespace App\Http\Controllers\Api\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Http\Resources\KhsResource;
use App\Models\KHS;

class KhsController extends Controller
{
    public function getMyKhs()
    {
        $myNim = auth()->id();

        $khss = KHS::where('mahasiswa_nim', $myNim)->orderBy('semester')->get();

        $sksKumulatifBefore = 0;
        foreach ($khss as $khs) {
            if ($sksKumulatifBefore !== 0) {
                $khs->sks_semester = $khs->sks_kumulatif - $sksKumulatifBefore;
            }
            if ($sksKumulatifBefore == 0) {
                $khs->sks_semester = $khs->sks_kumulatif;
            }
            $sksKumulatifBefore = $khs->sks_kumulatif;
        }

        return response()->json([
            'status' => 'success',
            'data' => KhsResource::collection($khss),
        ]);
    }
}
