<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource {

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request) {
        return [
            'type' => 'products',
            'id' => $this->id,
            'attributes' => [
                'category_id' => $this->category_id,
                'title' => $this->title,
                'slug' => $this->slug,
                'summary' => $this->summary,
                'content' => $this->content,
                'currency_id' => $this->currency_id,
                'currency' => $this->currency->getTranslation('title', userLanguage()),
                'price' => (string) $this->price_with_user_currency,
                'discount' => (string) $this->discount_with_user_currency,
                'final_price' => (string) $this->final_price_with_user_currency,
                'tags' => $this->tags,
                'image' => $this->image,
                'meta_description'=>$this->meta_description,
                'meta_keywords'=>$this->meta_keywords,
                'views' => (string) $this->views,
                'created_at' =>($this->created_at)?:date('Y-m-y H:i:s')
            ],
            'relationships' => [
                'category' => new TinyCategoryResource($this->category),
                'currency' => new TinyCurrencyResource($this->currency),
            ]
        ];
    }

}
