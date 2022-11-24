<?php

namespace App\Repositories;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;
use App\Base\BaseRepository;
use App\Events\ShowBlog;
use App\Models\Notification;

class NotificationRepository extends BaseRepository
{
    public function model(): string
    {
        return Notification::class;
    }

    public function index(int $member_id): Collection
    {
        return $this->model->newQuery()->where('receiver_id', $member_id)->orderBy('id', 'desc')->get();
    }

    public function getAllNotifications (): Collection
    {
        return $this->model->orderBy('id', 'desc')->get();
    }

    public function store(int $member_id, int $receiver_id, int $blog_id, string $type): Notification
    {
        $notify = new $this->model();
        $notify->setMemberId($member_id)
                ->setReceiverId($receiver_id)
                ->setBlogId($blog_id)
                ->setType($type)
                ->save();

        return $notify;
    }

    public function setNotificationSeen(int $id)
    {
        $notify = $this->model->findOrFail($id);
        $notify->setHasSeen(Notification::NOTIFICATION_HAS_SEEN)
            ->save();
        return $notify;
    }

}
