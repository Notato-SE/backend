<?php

namespace App\Http\Resources;

use App\Enums\RandomizerType;
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
            'name' => $this->name,
            'inputs' => json_decode($this->inputs),
            'results' => json_decode($this->results),
            'user_id' => $this->user_id,
            'random_type' => $this->random_type,
            'random_type_data' => RandomizerType::getDescription($this->random_type),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_at_display' => $this->created_at->diffForHumans(),
        ];
    }
}
