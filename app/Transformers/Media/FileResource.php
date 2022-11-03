<?php

namespace App\Transformers\Media;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Member;
use App\Transformers\Blog\BlogResource;
use Illuminate\Support\Carbon;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class FileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request
     * @return array
     */
    public function toArray($request): array
    {
        /** @var Media $media */
        $media = $this->resource;

        return [
            'id' => $media->id,
            'url' => $media->getFullUrl(),
            'name' => $media->getAttributeValue('file_name'),
            'type' => $media->getAttributeValue('mime_type'),
            'size' => $media->getAttributeValue('size'),
        ];
    }
}
