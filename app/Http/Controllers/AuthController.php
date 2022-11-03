<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Services\AuthService;
use App\Transformers\Auth\MemberDetailResource;
class AuthController extends Controller
{
    protected AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function logout(Request $request): JsonResponse
    {
        $this->authService->logout($request->user());

        return responder()->getSuccess();
    }

    public function info(Request $request): JsonResponse
    {
        $resource = new MemberDetailResource($request->user());

        return responder()->getSuccess($resource);
    }
}
