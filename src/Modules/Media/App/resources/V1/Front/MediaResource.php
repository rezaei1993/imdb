<?php

namespace Modules\Media\App\resources\V1\Front;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Media\App\Models\Media;


class MediaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request
     * @return array
     */
    public function toArray($request)
    {
        /** @var Media|self $this */
        return [
            'id' => $this->id,
            'files' => $this->files,
            'thumb' => $this->thumb,
        ];
    }
}
