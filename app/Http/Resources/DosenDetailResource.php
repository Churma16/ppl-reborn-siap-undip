<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DosenDetailResource extends JsonResource
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
            'nip' => $this->nip,
            'nama' => $this->nama,
            'foto_dosen' => $this->foto_dosen,
            'email' => $this->email,
            'no_hp' => $this->no_hp,
            'alamat' => $this->alamat,
        ];
    }
}
