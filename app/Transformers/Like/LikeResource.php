<?php

namespace App\Transformers\Like;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Like;
use Illuminate\Support\Carbon;

class LikeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request
     * @return array
     */
    public function toArray($request): array
    {
        /** @var Like $like */
        $like = $this->resource;

        return [
            'id' => $like->id,
            'member_id' => $like->member_id,
            'created_at' => Carbon::parse($like->created_at)->format(config('format.date_en')),
            'updated_at' => Carbon::parse($like->updated_at)->format(config('format.date_en')),
        ];
    }
}
