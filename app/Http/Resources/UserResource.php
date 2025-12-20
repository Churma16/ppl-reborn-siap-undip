<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'nip_nim' => $this->nip_nim,
            'username' => $this->username,
            'role' => $this->role->label(),
            'tanggal_gabung' => $this->created_at->format('d F Y'),
        ];
    }
}
