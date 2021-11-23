<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource {

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request) {
        return [
            'type' => 'users',
            'id' => $this->id,
            'attributes' => [
                'name' => $this->name,
                'email' => $this->email,
                'mobile' => $this->mobile,
                'currency_id' => $this->currency_id,
                'country_id' => $this->country_id,
                'language' => $this->language,
                'image' => $this->image,
                'last_logged_in_at' => $this->last_logged_in_at,
                'last_ip' => $this->last_ip,
                'created_at' =>($this->created_at)?:date('Y-m-y H:i:s')
            ],
            'relationships' => [
                'country' => new TinyCountryResource($this->country),
                'currency' => new TinyCurrencyResource($this->currency),
            ],
            'token'=>token(),
        ];
    }

}
