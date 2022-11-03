<?php

namespace App\Listeners;

use App\Events\ShowBlog;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\Blog;

class UpdateViewCount
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
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
