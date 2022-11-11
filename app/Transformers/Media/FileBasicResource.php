<?php

namespace App\Transformers\Media;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class FileBasicResource extends JsonResource
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
            'url' => $media->formFieldName ? $media->getFullUrl() : null,
        ];
    }
}
