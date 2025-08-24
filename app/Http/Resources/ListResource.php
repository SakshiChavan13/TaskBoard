<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
         return [
            'id'       => $this->id,
            'board_id' => $this->board_id,
            'name'     => $this->name,
            'position' => $this->position,

            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

            'cards' => CardResource::collection($this->whenLoaded('cards')),
        ];
    }
}
