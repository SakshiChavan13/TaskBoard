<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CardResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
   public function toArray($request)
    {
        return [
            'id'        => $this->id,
            'list_id'   => $this->list_id,
            'title'     => $this->title,
            'description' => $this->description,
            'position'  => $this->position,
            'due_date'  => $this->due_date,

            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
