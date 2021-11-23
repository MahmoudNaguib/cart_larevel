<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ContactResource extends JsonResource {

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request) {
        return [
            'type' => 'contacts',
            'id' => $this->id,
            'attributes' => [
                'email' => $this->email,
                'created_at' =>($this->created_at)?:date('Y-m-y H:i:s')
            ]
        ];
    }

}
