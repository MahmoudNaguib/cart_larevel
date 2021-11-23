<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CurrencyResource extends JsonResource {

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request) {
        return [
            'type' => 'currencies',
            'id' => $this->id,
            'attributes' => [
                'title' => $this->getTranslation('title', userLanguage()),
                'iso' => $this->iso,
                'rate' => (string) $this->rate,
                'created_at' =>($this->created_at)?:date('Y-m-y H:i:s')
            ]
        ];
    }

}
