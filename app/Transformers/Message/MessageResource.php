<?php

namespace App\Transformers\Message;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Message;
use Illuminate\Support\Carbon;
use App\Transformers\Member\MemberResource;
use App\Transformers\Media\FileBasicResource;

class MessageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request
     * @return array
     */
    public function toArray($request): array
    {
        /** @var Message $message */
        $message = $this->resource;
        return [
            'id' => $message->id,
            'content' => $message->content,
            'type' => $message->type,
            'has_seen' => $message->has_seen,
            'sender' => new MemberResource($message->sender),
            'receiver' => new MemberResource($message->receiver),
            'attachments' => FileBasicResource::collection($message->getMedia(Message::MESSAGE_MEDIA)),
            'created_at' => Carbon::parse($message->created_at)->format(config('format.date_en')),
            'updated_at' => Carbon::parse($message->updated_at)->format(config('format.date_en')),
        ];
    }
}
