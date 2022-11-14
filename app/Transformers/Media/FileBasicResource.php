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

        try {
            $url = $media->getFullUrl();
        } catch (\Throwable $th) {
            $url = null;
        }

        return [
            'url' => $url
        ];
    }
}
