<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Message;
use App\Models\Member;

class ShowMessage
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private Message $message;
    private Member $currentMember;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Message $message, Member $currentMember)
    {
        $this->message = $message;
        $this->currentMember = $currentMember;
    }

    public function getMessage(): Message
    {
        return $this->message;
    }

    public function getCurrentMember(): Member
    {
        return $this->currentMember;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn(): array
    {
        // return new PrivateChannel('channel-name');
        return [];
    }
}
