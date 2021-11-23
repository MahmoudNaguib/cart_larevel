<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SlideResource extends JsonResource {

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request) {
        return [
            'type' => 'slides',
            'id' => $this->id,
            'attributes' => [
                'title' => $this->getTranslation('title', userLanguage()),
                'content' => $this->getTranslation('content', userLanguage()),
                'url' => $this->url,
                'image' => $this->image,
                'views' => (string) $this->views,
                'created_at' =>($this->created_at)?:date('Y-m-y H:i:s')
            ]
        ];
    }

}
