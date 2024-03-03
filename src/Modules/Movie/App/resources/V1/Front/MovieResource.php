<?php

namespace Modules\Movie\App\resources\V1\Front;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Media\App\resources\V1\Front\MediaResource;
use Modules\Movie\App\Models\Movie;


class MovieResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        /** @var Movie|self $this */
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'imdb_thumbnail' => $this->imdb_thumbnail,
            'price' => $this->price,
            'imdb_id' => $this->imdb_id,
            'imdb_rating' => $this->imdb_rating,
            'video' => new MediaResource($this->video),
            'thumbnail' => new MediaResource($this->thumbnail),
        ];
    }
}
