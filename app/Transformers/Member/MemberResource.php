<?php

namespace App\Transformers\Member;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Member;
use App\Transformers\Blog\BlogResource;
use Illuminate\Support\Carbon;

class MemberResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request
     * @return array
     */
    public function toArray($request): array
    {
        /** @var Member $member */
        $member = $this->resource;
        return [
            'id' => $member->id,
            'name' => $member->name,
            'email' => $member->email,
            'dob' => convert_date_en_to_vn($member->dob),
            'phone_number' => $member->phone_number,
            'status' => $member->status,
            'blogs' => BlogResource::collection($member->blogs),
            'avatar' => $member->getMedia(Member::AVATAR_MEMBER),
            'created_at' => Carbon::parse($member->created_at)->format(config('format.date_en')),
            'updated_at' => Carbon::parse($member->updated_at)->format(config('format.date_en')),
        ];
    }
}
