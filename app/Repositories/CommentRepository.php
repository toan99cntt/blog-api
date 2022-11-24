<?php

namespace App\Repositories;

use App\Models\Comment;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Base\BaseRepository;
use Illuminate\Database\Eloquent\Collection;

class CommentRepository extends BaseRepository
{
    public function model(): string
    {
        return Comment::class;
    }

    public function index(Request $request): Collection
    {
        return $this->model->newQuery()->with('member', 'blog')->orderBy('id', 'desc')->get();
    }

    public function store(Request $request, int $memberId, int $blogId): Comment
    {
        /** @var Comment $comment */
        $comment = new $this->model();
        $comment
            ->setBlogId($blogId)
            ->setMemberId($memberId)
            ->setContent($request->get('content'))
            ->save();

        $blogRepository = app(BlogRepository::class);
        $blog = $blogRepository->findOrFail($blogId);
        if($memberId != $blog->member->id) {
            $notificationRepository = app(NotificationRepository::class);
            $notificationRepository->store($memberId, $blog->member->id, $blog->id, Notification::NOTIFICATION_TYPE_COMMENT);
        }

        return $comment;
    }

    public function update(Request $request, int $id): Comment
    {
        /** @var Comment $comment */
        $comment = $this->model->newQuery()->findOrFail($id);
        $comment
            ->setContent($request->get('content'))
            ->save();

        return $comment;
    }

    public function destroy(int $id): void
    {
        $this->model->newQuery()->findOrFail($id)->delete();
    }
}
