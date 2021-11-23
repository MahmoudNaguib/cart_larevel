<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TinyProductResource extends JsonResource {

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request) {
        return [
            'title' => $this->title,
            'currency' => $this->currency->getTranslation('title', userLanguage()),
            'price' => (string) $this->price_with_user_currency,
            'discount' => (string) $this->discount_with_user_currency,
            'final_price' => (string) $this->final_price_with_user_currency,
            'image' => $this->image,
        ];
    }

}
