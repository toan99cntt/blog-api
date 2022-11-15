<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Member;
use App\Models\Comment;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\HasMedia;
use App\Models\Like;

/**
 * @property integer id
 * @property string title
 * @property string content
 * @property integer view_count
 * @property integer like_count
 * @property Member member
 * @property Collection comments
 * @property integer status
 * @property integer created_at
 * @property integer updated_at
 */
class Blog extends Model implements HasMedia
{
    use HasFactory, SoftDeletes, InteractsWithMedia;

    protected $fillable = [
        'title',
        'content',
        'view_count',
        'like_count',
        'member_id',
        'status',
    ];

    const BLOG_MEDIA = 'blog_media';

    const IS_ACTIVE = 1;
    const INACTIVE = 0;

    const IS_PUBLISH = 1;
    const IS_DRAFT = 0;

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'deleted_at',
    ];

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class, 'member_id')->withTrashed();
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function likes(): HasMany
    {
        return $this->hasMany(Like::class);
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function setViewCount(int $viewCount): self
    {
        $this->view_count = $viewCount;

        return $this;
    }

    public function setLikeCount(int $likeCount): self
    {
        $this->like_count = $likeCount;

        return $this;
    }

    public function setMemberId(int $memberId): self
    {
        $this->member_id = $memberId;

        return $this;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function scopeIsPublish(Builder $query): Builder
    {
        return $query->where('status', self::IS_PUBLISH);
    }

    public function isPublish(): bool
    {
        return $this->status == self::IS_PUBLISH;
    }

    public function isDraft(): bool
    {
        return $this->status == self::IS_DRAFT;
    }
}
