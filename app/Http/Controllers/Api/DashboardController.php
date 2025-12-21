<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\IrsResource;
use App\Http\Resources\UserResource;
use App\Models\IRS;
use App\Models\User;

class DashboardController extends Controller
{
    public function getMyProfile()
    {
        $userProfileData = User::withFullProfile()
        ->where('nip_nim', auth()->id())
        ->first();

        return response()->json([
            'message' => 'Hai '.$userProfileData->username,
            'userProfileData' => new UserResource($userProfileData),
        ], 200);
    }

    public function getMyIrs()
    {
        $irs = IRS::with('semester')
        ->where('mahasiswa_nim', auth()->id())
        ->get();

        return response()->json([
            'message'=> 'Ini irs yang sudah kamu ambil',
            'data' => IrsResource::collection($irs),
        ], 200);
    }
}
