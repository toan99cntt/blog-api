<?php

namespace App\Exceptions;

use Exception;
use Throwable;
use Symfony\Component\HttpFoundation\Response;

class SpamForgotPasswordException extends Exception
{
    public function __construct(int $time, $message = "", $code = 0, Throwable $previous = null)
    {
        if (!$message) {
            $message = 'Bạn đang thao tác quá nhanh, vui lòng thử lại sau ' . $time . ' phút';
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
