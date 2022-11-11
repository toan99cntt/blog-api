<?php

namespace App\Transformers\Blog;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Blog;
use Illuminate\Support\Carbon;

class BlogResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request
     * @return array
     */
    public function toArray($request): array
    {
        /** @var Blog $blog */
        $blog = $this->resource;

        return [
            'id' => $blog->id,
            'status' => $blog->status,
            'title' => $blog->title,
            'content' => $blog->content,
            'view_count' => (int) $blog->view_count,
            'like_count' => (int) $blog->like_count,
            'created_at' => Carbon::parse($blog->created_at)->format(config('format.date_en')),
            'updated_at' => Carbon::parse($blog->updated_at)->format(config('format.date_en')),
        ];
    }
}
