<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AuthorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            // @TODO implement
            // implemented
            'id' => $this->id,           // Maps the object's id to an array element with key 'id'.
            'name' => $this->name,       // Maps the object's name to an array element with key 'name'.
            'surname' => $this->surname, // Maps the object's surname to an array element with key 'surname'.
        ];
    }
}
