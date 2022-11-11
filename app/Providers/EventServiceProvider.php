<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use App\Events\ShowBlog;
use App\Events\LikeBlog;
use App\Events\ShowMessage;
use App\Events\StoreMember;
use App\Listeners\UpdateViewCount;
use App\Listeners\UpdateHasSeen;
use App\Listeners\UpdateLikeCount;
use App\Listeners\SetDefaultRole;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        ShowBlog::class => [
            UpdateViewCount::class,
        ],
        ShowMessage::class => [
            UpdateHasSeen::class,
        ],
        LikeBlog::class => [
            UpdateLikeCount::class,
        ],
        StoreMember::class => [
            SetDefaultRole::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
