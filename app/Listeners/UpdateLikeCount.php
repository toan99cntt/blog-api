<?php

namespace App\Listeners;

use App\Events\LikeBlog;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\Blog;
use App\Repositories\LikeRepository;

class UpdateLikeCount
{

    private LikeRepository $likeRepository;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(LikeRepository $likeRepository)
    {
        $this->likeRepository = $likeRepository;
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\LikeBlog  $event
     * @return void
     */
    public function handle(LikeBlog $event)
    {
        /** @var Blog $blog */
        $blog = $event->getBlog();

        $likeCount = $this->likeRepository->getLikeCountByBlogId($blog->getKey());

        $blog->setLikeCount($likeCount)
            ->save();
    }
}
