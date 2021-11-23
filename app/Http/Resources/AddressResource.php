<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AddressResource extends JsonResource {

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request) {
        return [
            'type' => 'addresses',
            'id' => $this->id,
            'attributes' => [
                'title' => $this->title,
                'country' => $this->country->getTranslation('title', userLanguage()),
                'country_id' => $this->country_id,
                'city' => $this->city,
                'district' => $this->district,
                'zip_code' => $this->zip_code,
                'address' => $this->address,
                'notes' => $this->notes,
                'created_at' =>($this->created_at)?:date('Y-m-y H:i:s')
            ],
            'relationships' => [
                'country' => new TinyCountryResource($this->whenLoaded('country')),
            ]
        ];
    }

}
