<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Illuminate\Auth\Access\AuthorizationException;
use Laravel\Passport\Exceptions\OAuthServerException;


class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $e)
    {
        $error = responder()->setData(null);

        switch (true) {
            case $e instanceof OAuthServerException:
                return $error
                    ->setStatus(Response::HTTP_UNAUTHORIZED)
                    ->setErrMsg('Tài khoản hoặc mật khẩu không chính xác.')
                    ->get();
            case $e instanceof ModelNotFoundException:
                return $error
                    ->setStatus(Response::HTTP_NOT_FOUND)
                    ->setErrMsg('Không tìm thấy bản ghi.')
                    ->get();
            case $e instanceof NotFoundHttpException:
                return $error
                    ->setStatus(Response::HTTP_NOT_FOUND)
                    ->setErrMsg('Đường dẫn không tồn tại.')
                    ->get();
            case $e instanceof AuthenticationException:
                return $error
                    ->setStatus(Response::HTTP_UNAUTHORIZED)
                    ->setErrMsg($e->getMessage())
                    ->get();
            case $e instanceof ValidationException:
                return $error
                    ->setErrMsg($e->getMessage())
                    ->setData($e->errors())
                    ->setStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
                    ->get();
            case $e instanceof MethodNotAllowedHttpException:
                return $error
                    ->setStatus($e->getStatusCode())
                    ->setErrMsg($e->getMessage())
                    ->get();
            case $e instanceof AuthorizationException:
                $e = new AccessDeniedHttpException($e->getMessage(), $e);
                $message = $e->getMessage() === 'This action is unauthorized.' ? 'Không có quyền thực hiện.' : $e->getMessage();

                return $error
                    ->setStatus($e->getStatusCode())
                    ->setErrMsg($message)
                    ->get();
            default:
                return $error
                    ->setData(['exception' => get_class($e)])
                    ->get();
        }
    }
}
