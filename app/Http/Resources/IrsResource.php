<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class IrsResource extends JsonResource
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
            'id'=> $this->id,
            'semester_aktif' => $this->semester_aktif,
            'status_konfirmasi'=> $this->status_konfirmasi,
            'jumlah_sks' => $this->jumlah_sks,
            'file_sks' =>$this->file_sks,
            // 'tanggal_dibuat' => $this->created_at->format('d-m-Y'),
            'semester' => new SemesterResource($this->whenLoaded('semester'))
        ];
    }
}
