<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BookReviewResource extends JsonResource
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
            "id" => $this->id,                  // Maps the object's id property to an array element with key 'id'.
            "review" => $this->review,          // Maps the object's review property to an array element with key 'review'.
            "comment" => $this->comment,        // Maps the object's comment property to an array element with key 'comment'.
            "user" => [
                "id" => $this->user->id,        // Maps the user's id property to an array element within the 'user' array with key 'id'.
                "name" => $this->user->name,    // Maps the user's name property to an array element within the 'user' array with key 'name'.
            ],
        ];
    }
}
