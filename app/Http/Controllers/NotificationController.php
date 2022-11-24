<?php

namespace App\Http\Controllers;

use App\Repositories\NotificationRepository;
use App\Transformers\Notification\NotificationResource;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    protected NotificationRepository $notificationRepository;

    public function __construct(NotificationRepository $notificationRepository) {
        $this->notificationRepository = $notificationRepository;
    }

    public function index(Request $request)
    {
        $member_id = $request->user()->getKey();
        $notifications = $this->notificationRepository->index($member_id);
        $collection = NotificationResource::collection($notifications);

        return responder()->getSuccess($collection);
    }

    public function getAllNotifications() {
        $notifications = $this->notificationRepository->getAllNotifications();
        $collection = NotificationResource::collection($notifications);

        return responder()->getSuccess($collection);
    }

    public function setNotificationSeen(int $id) {
        $notification = $this->notificationRepository->setNotificationSeen($id);

        return responder()->getSuccess($notification);
    }
}
