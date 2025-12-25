<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class KhsResource extends JsonResource
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
            'semester' => $this->semester,
            'sks_semester' => $this->sks_semester,
            'sks_kumulatif' => $this->sks_kumulatif,
            'ip_semester' => round($this->ip_semester, 2),
            'ip_kumulatif' => $this->ip_kumulatif,
            'status' => $this->status_konfirmasi,
        ];
    }
}
