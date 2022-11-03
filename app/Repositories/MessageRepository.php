<?php

namespace App\Repositories;

use App\Models\Message;
use Illuminate\Http\UploadedFile;
use App\Base\BaseRepository;

class MessageRepository extends BaseRepository
{
    public function model(): string
    {
        return Message::class;
    }

    public function sendMessage(int $senderId, int $receiverId, string $content): Message
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

    public function sendImages(int $senderId, int $receiverId, array $images): Message
    {
        /** @var Message $message */
        $message = new $this->model();
        $message
            ->setSenderId($senderId)
            ->setReceiverId($receiverId)
            ->setType(Message::MESSAGE_TYPE_TEXT)
            ->setHasSeen(Message::MESSAGE_NOT_SEEN)
            ->save();

       /** @var UploadedFile $image */
       foreach ($images as $image) {
            $message->addMedia($image)->toMediaCollection(Message::MESSAGE_MEDIA);
        }

        return $message;
    }

}
