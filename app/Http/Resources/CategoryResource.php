<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource {

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request) {
        return [
            'type' => 'categories',
            'id' => $this->id,
            'attributes' => [
                'title' => $this->title,
                'image' => $this->image,
                'meta_description'=>$this->meta_description,
                'meta_keywords'=>$this->meta_keywords,
                'created_at' =>($this->created_at)?:date('Y-m-y H:i:s')
            ]
        ];
    }

}
