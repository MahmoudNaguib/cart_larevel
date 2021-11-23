<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ConfigResource extends JsonResource {

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request) {
        return [
            'type' => 'configs',
            'id' => $this->id,
            'attributes' => [
                'field' => $this->field,
                'value' => $this->value,
            ]
        ];
    }

}
