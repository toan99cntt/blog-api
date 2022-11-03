<?php

namespace App\Services;

use Laravel\Passport\Token;
use Laravel\Passport\RefreshTokenRepository;

class AuthService
{
    public function logout($user): void
    {
        $this->revokeToken($user->token());
    }

    protected function revokeToken(Token $token): void
    {
        $token->revoke();
        /** @var RefreshTokenRepository $refreshTokenRepository */
        $refreshTokenRepository = app(RefreshTokenRepository::class);
        $refreshTokenRepository->revokeRefreshTokensByAccessTokenId($token->getKey());
    }
}
