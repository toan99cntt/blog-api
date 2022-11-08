<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\CommentRepository;
use App\Transformers\Comment\CommentResource;
use Illuminate\Http\JsonResponse;

class CommentController extends Controller
{
    protected CommentRepository $repository;

    public function __construct(CommentRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(Request $request)
    {
        $blogs = $this->repository->index($request);
        $collection = CommentResource::collection($blogs);

        return responder()->getSuccess($collection);
    }

    public function store(Request $request, int $blogId): JsonResponse
    {
        $comment = $this->repository->store(
            $request,
            $request->user()->getKey(),
            $blogId
        );
        $resource = new CommentResource($comment);

        return responder()->getSuccess($resource);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $comment = $this->repository->update($request, $id);
        $resource = new CommentResource($comment);

        return responder()->getSuccess($resource);
    }

    public function destroy(int $id): JsonResponse
    {
        $this->repository->destroy($id);

        return responder()->getSuccess();
    }

}
