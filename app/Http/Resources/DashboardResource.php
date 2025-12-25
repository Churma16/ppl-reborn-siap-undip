<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DashboardResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'mahasiswa' => [
                'nama' => $this->nama,
                'nim' => $this->nim,
                'foto_profile' => $this->foto_mahasiswa,
                'status_akademik' => $this->status_akademik,

            ],
            'semester_aktif' => $this->irsAktif->semester_aktif ?? 1,
            'rekap_akademik' => [
                'ipk' => $this->khs->sortByDesc('semester')->first()->ip_kumulatif ?? 0,
                'sks_kumulatif'=>$this->khs->sortByDesc('semester')->first()->sks_kumulatif ??0,
                'status_pkl' => $this->pkl->sortByDesc('progress_ke')->first()->status_lulus ?? 'Belum Ambil',
                'status_skripsi' => $this->skripsi->sortByDesc('progress_ke')->first()->status_skripsi?? 'Belum Ambil'
            ],
        ];
    }
}
