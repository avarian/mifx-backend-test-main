<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
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
            'id' => $this->id,                                                          // Maps the object's id property to an array element with key 'id'.
            'isbn' => $this->isbn,                                                      // Maps the object's isbn property to an array element with key 'isbn'.
            'title' => $this->title,                                                    // Maps the object's title property to an array element with key 'title'.
            'description' => $this->description,                                        // Maps the object's description property to an array element with key 'description'.
            'published_year' => $this->published_year,                                  // Maps the object's published_year property to an array element with key 'published_year'.
            'authors' => AuthorResource::collection($this->authors),                    // Maps a collection of authors to an array element with key 'authors'.
            'book_contents' => BookContentResource::collection($this->bookContents),    // Maps a collection of book contents to an array element with key 'book_contents'.
            'price' => $this->price,                                                    // Maps the object's price property to an array element with key 'price'.
            'price_rupiah' => usd_to_rupiah_format($this->price),                       // Converts the object's price to Indonesian Rupiah and maps it to an array element with key 'price_rupiah'.
            'review' => [
                'avg' => (int) round($this->reviews->avg('review')),                    // Maps the average review rating (rounded) to an array element with key 'avg'.
                'count' => (int) $this->reviews->count(),                               // Maps the total number of reviews to an array element with key 'count'.
            ],
        ];
    }
}
