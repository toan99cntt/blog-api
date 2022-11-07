<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Blog;
use App\Models\Member;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property integer id
 * @property integer blog_id
 * @property string content
 * @property integer like_count
 * @property Blog blog
 * @property Member member
 * @property integer created_at
 * @property integer updated_at
 */
class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'blog_id',
        'member_id',
        'content',
        'like_count',
    ];

    public function blog(): BelongsTo
    {
        return $this->belongsTo(Blog::class, 'blog_id')->withTrashed();
    }

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class, 'member_id')->withTrashed();
    }

    public function setBlogId(int $blogId): self
    {
        $this->blog_id = $blogId;

        return $this;
    }

    public function setMemberId(int $memberId): self
    {
        $this->member_id = $memberId;

        return $this;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function setLikeCount(string $likeCount): self
    {
        $this->likeCount = $likeCount;

        return $this;
    }

}
