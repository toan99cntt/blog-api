<?php

namespace App\Transformers\Notification;

use App\Repositories\MemberRepository;
use App\Transformers\Auth\MemberResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Notification;
use Illuminate\Support\Carbon;

class NotificationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request
     * @return array
     */
    public function toArray($request): array
    {
        /** @var Notification $notify */
        $notify = $this->resource;

        return [
            'id' => $notify->id,
            'content' => $this->getContent($notify),
            'type' => $this->type,
            'blog_id' => $notify->blog_id,
            'has_seen' => $notify->has_seen,
            'receiver' => $this->getReceiver($notify->receiver_id),
            'sender' => new MemberResource($notify->member),
            'created_at' => Carbon::parse($notify->created_at)->format(config('format.date_en')),
            'updated_at' => Carbon::parse($notify->updated_at)->format(config('format.date_en')),
        ];
    }

    private function getContent(Notification $notify)
    {
        $name = $notify->member->name;
        if($notify->type == Notification::NOTIFICATION_TYPE_LIKE) {
            return $name . " liked your post.";
        } else if ($notify->type == Notification::NOTIFICATION_TYPE_COMMENT) {
            return $name . " commented your post.";
        } else {
            return;
        }
    }

    private function getReceiver(int $receiverId) {
        $memberRepository = app(MemberRepository::class);
        $receiver = $memberRepository->findOrFail($receiverId);

        return new MemberResource($receiver);
    }
}
