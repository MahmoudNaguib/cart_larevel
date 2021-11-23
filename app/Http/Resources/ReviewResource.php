<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource {

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request) {
        return [
            'type' => 'reviews',
            'id' => $this->id,
            'attributes' => [
                'product_id' => $this->product_id,
                'content' => $this->content,
                'rate' => $this->rate,
                'created_at' =>($this->created_at)?:date('Y-m-y H:i:s')
            ],
            'relationships' => [
                'product' => new TinyProductResource($this->product),
            ]
        ];
    }

}
