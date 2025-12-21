<?php

namespace App\Http\Resources;

use App\Http\Resources\ProvinsiResource;
use App\Http\Resources\KabupatenResource;
use Illuminate\Http\Resources\Json\JsonResource;

class MahasiswaResource extends JsonResource
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
            'nim' => $this->nim,
            'nama' => $this->nama,
            'foto_mahasiswa' => $this->foto_mahasiswa,
            'angkatan' => $this->angkatan,
            'email' => $this->email,
            'no_hp' => $this->no_hp,
            'jalur_masuk' => $this->jalur_masuk,
            'provinsi' => new ProvinsiResource($this->whenLoaded('provinsi')),
            'kabupaten'=> new KabupatenResource($this->whenLoaded('kabupaten')),
            'dosen_wali' => new DosenSimpleResource($this->whenLoaded('dosen')),
        ];
    }
}
