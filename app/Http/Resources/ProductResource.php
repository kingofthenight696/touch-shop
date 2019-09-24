<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'board_id' => $this->board_id,
            'title' => $this->title,
            'description' => $this->description,
            'price' => $this->price ?? 0,
        ];
    }
}
