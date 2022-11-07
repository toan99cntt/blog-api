<?php

namespace App\Repositories;

use App\Models\Like;
use App\Base\BaseRepository;
use App\Events\LikeBlog;
use App\Repositories\BlogRepository;

class LikeRepository extends BaseRepository
{
    public function model(): string
    {
        return Like::class;
    }

    public function likeAndUnlike(int $blogId, int $memberId): void
    {
        $like = $this->model->newQuery()
            ->where('blog_id', $blogId)
            ->where('member_id', $memberId)
            ->first();

        if ($like) {
            $like->delete();
        } else {
            /** @var Like $like */
            $like = new $this->model();
            $like
                ->setBlogId($blogId)
                ->setMemberId($memberId)
                ->save();
        }

        /** @var BlogRepository $blogRepository */
        $blogRepository = app(BlogRepository::class);

        $blog = $blogRepository->findOrFail($blogId);

        LikeBlog::dispatch($blog);
    }

    public function getLikeCountByBlogId(int $blogId): int
    {
        return $this->model->newQuery()->where('blog_id', $blogId)->count();
    }

}
