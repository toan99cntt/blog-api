<?php

namespace App\Repositories;

use App\Models\Comment;
use Illuminate\Http\Request;
use App\Base\BaseRepository;

class CommentRepository extends BaseRepository
{
    public function model(): string
    {
        return Comment::class;
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
