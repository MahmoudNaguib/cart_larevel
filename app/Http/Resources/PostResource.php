<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource {

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request) {
        return [
            'type' => 'posts',
            'id' => $this->id,
            'attributes' => [
                'section_id'=>$this->section_id,
                'title' => $this->getTranslation('title', userLanguage()),
                'slug' => $this->getTranslation('slug', userLanguage()),
                'summary' => $this->getTranslation('summary', userLanguage()),
                'content' => $this->getTranslation('content', userLanguage()),
                'tags' => $this->getTranslation('content', userLanguage()),
                'meta_description'=>$this->meta_description,
                'meta_keywords'=>$this->meta_keywords,
                'image' => $this->image,
                'views' => (string) $this->views,
                'created_at' =>($this->created_at)?:date('Y-m-y H:i:s')
            ],
            'relationships' => [
                'section' => new TinySectionResource($this->section),
            ]
        ];
    }

}
