<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Member;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\HasMedia;

/**
 * Class Message
 * @package Modules\Chat\Models
 * @property integer id
 * @property integer sender_id
 * @property integer receiver_id
 * @property string content
 * @property string type
 * @property integer has_seen
 * @property Member sender
 * @property Member receiver
 * @property integer created_at
 * @property integer updated_at
 */
class Message extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'sender_id',
        'receiver_id',
        'content',
        'type',
        'has_seen',
    ];

    const MESSAGE_TYPE_TEXT = 'text';
    const MESSAGE_TYPE_IMAGE = 'image';
    const MESSAGE_TYPE_FILE = 'file';

    const MESSAGE_NOT_SEEN = 1;
    const MESSAGE_HAS_SEEN = 2;

    const MESSAGE_MEDIA = 'message_media';

    public function setSenderId(int $senderId): self
    {
        $this->sender_id = $senderId;

        return $this;
    }

    public function setReceiverId(int $receiverId): self
    {
        $this->receiver_id = $receiverId;

        return $this;
    }

    public function setContent(?string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function setHasSeen(int $hasSeen): self
    {
        $this->has_seen = $hasSeen;

        return $this;
    }

    public function sender(): BelongsTo
    {
        return $this->belongsTo(Member::class, 'sender_id');
    }

    public function receiver(): BelongsTo
    {
        return $this->belongsTo(Member::class, 'receiver_id');
    }
}
