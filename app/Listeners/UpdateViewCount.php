<?php

namespace App\Listeners;

use App\Events\ShowBlog;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Repositories\BlogRepository;
use App\Models\Blog;

class UpdateViewCount
{

    private BlogRepository $blogRepository;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(BlogRepository $blogRepository)
    {
        $this->blogRepository = $blogRepository;
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\ShowBlog  $event
     * @return void
     */
    public function handle(ShowBlog $event)
    {
        /** @var Blog $blog */
        $blog = $event->getBlog();
        $blog->setViewCount($blog->view_count + 1)
            ->save();
    }
}
