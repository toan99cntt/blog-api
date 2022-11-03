<?php

namespace App\Services;

use Symfony\Component\HttpFoundation\Response as ResponseStatus;
use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;

class ResponseService
{
    private array $response;

    public function __construct()
    {
        $this->response = [];
        $this->setMsg('OK');
        $this->setErrMsg('');
    }

    public function setStatus(int $status): self
    {
        $this->response['status'] = $status;

        return $this;
    }

    public function setMsg(string $msg): self
    {
        $this->response['msg'] = $msg;

        return $this;
    }

    public function setErrMsg(string $errMsg): self
    {
        $this->response['error_messages'] = $errMsg;

        return $this;
    }

    /**
     * @param mixed $data
     * @return self
     */
    public function setData($data = []): self
    {
        $this->response['data'] = $data;

        return $this;
    }

    /**
     * @param mixed $data
     * @return JsonResponse
     */
    public function getSuccess($data = []): JsonResponse
    {
        return $this->setStatus(ResponseStatus::HTTP_OK)->setData($data)->get();
    }

    public function get(): JsonResponse
    {
        return response()->json($this->response);
    }

    public function getResponse(): array
    {
        return $this->response;
    }

    public function getPaginator(LengthAwarePaginator $paginator, string $resourceClass): JsonResponse
    {
        $data = [
            'current_page' => $paginator->currentPage(),
            'results' => $resourceClass::collection($paginator->getCollection()),
            'from' => $paginator->firstItem(),
            'last_page' => $paginator->lastPage(),
            'per_page' => $paginator->perPage(),
            'to' => $paginator->lastItem(),
            'total' => $paginator->total(),
        ];

        return $this->setStatus(ResponseStatus::HTTP_OK)->setData($data)->get();
    }
}
