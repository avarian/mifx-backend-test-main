<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BookContentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            // @TODO implement
            // implemented
            'id' => $this->id,                  // Maps the object's id to an array element with key 'id'.
            'label' => $this->label,            // Maps the object's label to an array element with key 'label'.
            'title' => $this->title,            // Maps the object's title to an array element with key 'title'.
            'page_number' => $this->page_number // Maps the object's page_number to an array element with key 'page_number'.
        ];
    }
}
