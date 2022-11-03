<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\MessageRepository;
use Illuminate\Http\JsonResponse;
use App\Transformers\Message\MessageResource;

class MessageController extends Controller
{
    protected MessageRepository $repository;

    public function __construct(MessageRepository $repository)
    {
        $this->repository = $repository;
    }

    public function sendMessage(Request $request, int $id): JsonResponse
    {
        $message = $this->repository->sendMessage(
            $request->user()->getKey(),
            $id,
            $request->get('content')
        );

        $resource = new MessageResource($message);

        return responder()->getSuccess($resource);
    }

    public function sendImages(Request $request, int $id): JsonResponse
    {
        $message = $this->repository->sendImages(
            $request->user()->getKey(),
            $id,
            $request->file('images')
        );

        $resource = new MessageResource($message);

        return responder()->getSuccess($resource);
    }
}
