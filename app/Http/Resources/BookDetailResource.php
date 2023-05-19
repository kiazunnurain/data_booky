<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'image' => $this->image,
            'author' => $this->author,
            'synopsis_content' => $this->synopsis_content,
            'created_at' => date_format($this->created_at, "Y/m/d H:i:s"),
            'writer' => $this->writer,
            'penulis' => $this->penulis,
            'reviews' => $this->whenLoaded('reviews', function ()
            {
                return collect($this->reviews)->each(function ($review) {
                    $review->reviewer;
                    return $review;
                });
            }),
            'review_total' => $this->whenLoaded('reviews', function(){
                return $this->reviews->count();
            })
        ];
    }
}
