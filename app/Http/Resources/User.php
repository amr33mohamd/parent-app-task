<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class User extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'email' => $this->email,
            'created_at' => $this->created_at,
            'balance'=> $this->balance,
            'status'=> $this->status,
            'currency'=> $this->currency,
            'identification'=> $this->identification,
            'provider'=> $this->provider,
        ];
    }
}
