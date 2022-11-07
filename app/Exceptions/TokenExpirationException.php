<?php

namespace App\Exceptions;

use Exception;
use Throwable;
use Symfony\Component\HttpFoundation\Response;

class TokenExpirationException extends Exception
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        if (!$message) {
            $message = 'Token đã hết hạn sử dụng.';
        }
        parent::__construct($message, $code, $previous);
    }

    public function toResponse($request)
    {
        return responder()
            ->setStatus(Response::HTTP_BAD_REQUEST)
            ->setData(null)
            ->setErrMsg($this->getMessage())
            ->get();
    }
}
