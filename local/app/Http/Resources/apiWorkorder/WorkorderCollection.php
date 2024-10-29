<?php

namespace App\Http\Resources\ApiWorkorder;

use Illuminate\Http\Resources\Json\ResourceCollection;

class WorkorderCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'data' => WorkorderResource::collection($this->collection),
            'meta' => [
                'total_workorder_data' => $this->collection->count()
            ]
        ];
    }
}
