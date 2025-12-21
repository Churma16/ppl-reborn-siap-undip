<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class KabupatenResource extends JsonResource
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
            'kode_kabupaten' => $this->kode_kabupaten,
            'nama' => $this->nama,
        ];
    }
}
