<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RandomizerResource extends JsonResource
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
            'id' => $this->id,
            'inputs' => json_decode($this->inputs),
            'resutls' => json_decode($this->results),
            'user_id' => $this->user_id,
            'random_type' => $this->random_type,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
