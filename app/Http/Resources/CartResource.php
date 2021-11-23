<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource {

    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request) {
        return [
            'type' => 'cart',
            'id' => $this->id,
            'attributes' => [
                'product_id' => $this->product_id,
                'quantity' => $this->quantity,
                'created_at' =>($this->created_at)?:date('Y-m-y H:i:s')
            ],
            'relationships' => [
                'product' => new TinyProductResource($this->product),
            ]
        ];
    }

}
