<?php

namespace App\Repositories;

use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use App\Base\BaseRepository;

class MessageRepository extends BaseRepository
{
    public function model(): string
    {
        return Message::class;
    }

    public function sendMessage(int $senderId, int $receiverId, string $content)
    {
        /** @var Message $message */
        $message = new $this->model();
        $message
            ->setSenderId($senderId)
            ->setReceiverId($receiverId)
            ->setContent($content)
            ->setType(Message::MESSAGE_TYPE_TEXT)
            ->setHasSeen(Message::MESSAGE_NOT_SEEN)
            ->save();

        return $message;
    }

}
