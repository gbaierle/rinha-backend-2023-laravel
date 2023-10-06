<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PersonResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'uuid' => $this->uuid,
            'apelido' => $this->nick,
            'nome' => $this->name,
            'nascimento' => $this->birth_date->format('Y-m-d'),
            'stack' => $this->stack,
        ];
    }
}
