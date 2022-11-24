<?php

namespace App\Repositories;

use App\Models\Message;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use App\Base\BaseRepository;
use App\Events\ShowMessage;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use App\Repositories\MemberRepository;

class MessageRepository extends BaseRepository
{
    public function model(): string
    {
        return Message::class;
    }

    public function getMessages(int $senderId, int $receiverId): Collection
    {
        $messages = $this->model->newQuery()
            ->whereIn('sender_id', [$senderId, $receiverId])
            ->whereIn('receiver_id', [$senderId, $receiverId])
            ->get();

        return $messages;
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

    public function getMemberChat(Request $request)
    {
        $members = $this->model->newQuery()
            ->where('receiver_id', $request->user()->getKey())
            ->orWhere('sender_id', $request->user()->getKey());

        $memberSent = $this->getMemberSent($members);
        $memberReceived = $this->getMemberReceived($members);

        $members = array_merge($memberReceived, $memberSent);
        $members = array_unique($members);
        $members = array_filter($members,function ($k) use ($request) {
            return $k != $request->user()->getKey();
        } );

        $messages = collect([]);
        foreach ($members as $id) {
            $message = $this->getIdMessages($id, $request->user()->getKey());
            $messages->push($message);
        }

        return $messages->sortDesc();
    }

    public function getMemberSent($members): Array
    {
        return $members->groupBy('sender_id')->pluck('sender_id')->toArray();
    }

    public function getMemberReceived($members): Array
    {
        return $members->groupBy('receiver_id')->pluck('receiver_id')->toArray();
    }

    public function getIdMessages(int $receiverId, int $senderId ): Message
    {
        return $this->model->newQuery()
            ->with(['sender', 'receiver'])
            ->whereIn('sender_id', [$senderId, $receiverId])
            ->whereIn('receiver_id', [$senderId, $receiverId])
            ->orderBy('id', 'desc')
            ->first();
    }
}
