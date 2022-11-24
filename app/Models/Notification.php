<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property integer id
 * @property string content
 * @property integer member_id
 * @property integer created_at
 * @property integer updated_at
 */

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'type',
        'member_id',
        'receiver_id',
        'blog_id',
        'has_seen'
    ];

    const NOTIFICATION_NOT_SEEN = 1;
    const NOTIFICATION_HAS_SEEN = 0;

    const NOTIFICATION_TYPE_LIKE = "like";
    const NOTIFICATION_TYPE_COMMENT = "COMMENT";

    public function setType(?string $type):self
    {
        $this->type = $type;
        return $this;
    }

    public function setMemberId(?int $member_id):self
    {
        $this->member_id = $member_id;
        return $this;
    }

    public function setReceiverId(?int $receiver_id):self
    {
        $this->receiver_id = $receiver_id;
        return $this;
    }

    public function setHasSeen(?int $has_seen):self
    {
        $this->has_seen = $has_seen;
        return $this;
    }

    public function setBlogId(?int $blogId):self
    {
        $this->blog_id = $blogId;
        return $this;
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function blog()
    {
        return $this->belongsTo(Blog::class);
    }
}
