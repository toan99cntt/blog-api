<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\MessageRepository;
use Illuminate\Http\JsonResponse;
use App\Transformers\Message\MessageResource;
use App\Http\Requests\Message\SendMessageRequest;
use App\Http\Requests\Message\SendImageRequest;
use App\Http\Requests\Message\SendFileRequest;

class MessageController extends Controller
{
    protected MessageRepository $repository;

    public function __construct(MessageRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getMessages(Request $request, int $id): JsonResponse
    {
        $senderId = $request->user()->getKey();
        $receiverId = $id;

        $messages = $this->repository->getMessages($senderId, $receiverId);
        $resource = MessageResource::collection($messages);

        return responder()->getSuccess($resource);
    }

    public function show(Request $request, int $id): JsonResponse
    {
        $message = $this->repository->show($id, $request->user());

        $resource = new MessageResource($message);

        return responder()->getSuccess($resource);
    }

    public function sendMessage(SendMessageRequest $request, int $id): JsonResponse
    {
        $message = $this->repository->sendMessage(
            $request->user()->getKey(),
            $id,
            $request->get('content')
        );

        $resource = new MessageResource($message);

        return responder()->getSuccess($resource);
    }

    public function sendImages(SendImageRequest $request, int $id): JsonResponse
    {
        $message = $this->repository->sendImages(
            $request->user()->getKey(),
            $id,
            $request->file('images')
        );

        $resource = new MessageResource($message);

        return responder()->getSuccess($resource);
    }

    public function sendFiles(SendFileRequest $request, int $id): JsonResponse
    {
        $message = $this->repository->sendFiles(
            $request->user()->getKey(),
            $id,
            $request->file('files')
        );

        $resource = new MessageResource($message);

        return responder()->getSuccess($resource);
    }
}
