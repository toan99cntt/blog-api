<?php

namespace App\Transformers\Comment;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Comment;
use Illuminate\Support\Carbon;
use App\Transformers\Member\MemberResource;

class CommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request
     * @return array
     */
    public function toArray($request): array
    {
        /** @var Comment $comment */
        $comment = $this->resource;

        return [
            'id' => $comment->id,
            'content' => $comment->content,
            'like_count' => (int) $comment->like_count,
            'member' => new MemberResource($comment->member),
            'created_at' => Carbon::parse($comment->created_at)->format(config('format.date_en')),
            'updated_at' => Carbon::parse($comment->updated_at)->format(config('format.date_en')),
        ];
    }
}
