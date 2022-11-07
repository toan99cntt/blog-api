<?php

namespace App\Repositories;

use App\Models\Message;
use Illuminate\Http\UploadedFile;
use App\Base\BaseRepository;
use App\Events\ShowMessage;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class MessageRepository extends BaseRepository
{
    public function model(): string
    {
        return Message::class;
    }

    public function index(Request $request): Collection
    {
        return $this->model->newQuery()->get();
    }

    public function show(int $id, Member $member): Message
    {
        $message = $this->model->findOrFail($id);

        ShowMessage::dispatch($message, $member);

        return $message;
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
            ->setType(Message::MESSAGE_TYPE_IMAGE)
            ->setHasSeen(Message::MESSAGE_NOT_SEEN)
            ->save();

       /** @var UploadedFile $image */
       foreach ($images as $image) {
            $message->addMedia($image)->toMediaCollection(Message::MESSAGE_MEDIA);
        }

        return $message;
    }

    public function sendFiles(int $senderId, int $receiverId, array $files): Message
    {
        /** @var Message $message */
        $message = new $this->model();
        $message
            ->setSenderId($senderId)
            ->setReceiverId($receiverId)
            ->setType(Message::MESSAGE_TYPE_FILE)
            ->setHasSeen(Message::MESSAGE_NOT_SEEN)
            ->save();

       /** @var UploadedFile $file */
       foreach ($files as $file) {
            $message->addMedia($file)->toMediaCollection(Message::MESSAGE_MEDIA);
        }

        return $message;
    }

}
