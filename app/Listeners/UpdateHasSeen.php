<?php

namespace App\Listeners;

use App\Events\ShowMessage;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\Message;
use App\Models\Member;

class UpdateHasSeen
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
     * @param  \App\Events\ShowMessage  $event
     * @return void
     */
    public function handle(ShowMessage $event)
    {
        /** @var Message $message */
        $message = $event->getMessage();

        /** @var Member $member */
        $member = $event->getCurrentMember();

        if ($member->id == $message->receiver_id) {
            $message->setHasSeen(Message::MESSAGE_HAS_SEEN)
                ->save();
        }
    }
}
