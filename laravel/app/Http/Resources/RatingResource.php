<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RatingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return[
            'user_id' => $this->user_id,
            'book_id'=>$this->book_id,
            'rating' => $this->rating,
            'created_at'=>$this->created_at,
            'updated_at'=>$this->updated_at,
            'book' => $this->book,
        ];
    }
}
