<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property integer id
 * @property integer member_id
 * @property integer blog_id
 * @property integer created_at
 * @property integer updated_at
 */
class Like extends Model
{
    use HasFactory;

    protected $fillable = [
        'blog_id',
        'member_id',
    ];

    public function setMemberId(int $memberId): self
    {
        $this->member_id = $memberId;

        return $this;
    }

    public function setBlogId(int $blogId): self
    {
        $this->blog_id = $blogId;

        return $this;
    }
}
