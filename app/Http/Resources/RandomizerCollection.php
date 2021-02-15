<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class RandomizerCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => $this->collection,
            'pagination' => [
                'total' => $this->total(),
                'current_page_num' => $this->currentPage(),
                'next_page' => $this->nextPageUrl(),
                'previous_page' => $this->previousPageUrl(),
                'last_page' => $this->lastPage(),
            ]
        ];
    }
}
