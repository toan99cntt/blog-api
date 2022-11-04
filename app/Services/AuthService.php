<?php

namespace App\Services;

use Exception;
use App\Exceptions\EmailNotExistException;
use App\Exceptions\SpamForgotPasswordException;
use App\Exceptions\TokenExpirationException;
use Laravel\Passport\Token;
use Laravel\Passport\RefreshTokenRepository;
use App\Models\Member;
use App\Models\MemberPasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\ForgotPassword;
use App\Mail\PasswordReset;
use App\Repositories\MemberRepository;

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

    /**
     * @throws Exception
     */
    public function forgotPassword(Request $request): Member
    {
        /** @var MemberRepository $memberRepository */
        $memberRepository = app(MemberRepository::class);

        $member = $memberRepository->findByEmail($request->get('email'));
        if (is_null($member)) {
            throw new EmailNotExistException();
        }

        $token = Str::random(MemberPasswordReset::TOKEN_LENGTH);
        $memberPasswordReset = $this->updateTokenPasswordReset($member->email, $token);
        $requestInfo = [
            'ip' => $request->header('X-Real-IP', $request->ip()),
            'device' => $request->userAgent(),
        ];
        Mail::to($member->email)->send(new ForgotPassword($memberPasswordReset, $member, $requestInfo));

        return $member;
    }

    /**
     * @throws Exception
     */
    protected function updateTokenPasswordReset(string $email, string $token): MemberPasswordReset
    {
        $memberPasswordReset = MemberPasswordReset::query()->where('email', $email)->first();

        if (is_null($memberPasswordReset)) {
            $memberPasswordReset = MemberPasswordReset::query()->create([
                'email' => $email,
                'token' => $token,
            ]);

            return $memberPasswordReset;
        }

        $check = $this->checkSpamForgotPassword($memberPasswordReset);
        if ($check) {
            $diffMinutes = Carbon::now()->diffInMinutes($memberPasswordReset->updated_at);
            $timeRemaining = MemberPasswordReset::TIME_DISTANCE - $diffMinutes;
            if ($timeRemaining === 0) {
                $timeRemaining += 1;
            }

            throw new SpamForgotPasswordException($timeRemaining);
        }

        $memberPasswordReset->update([
            'token' => $token
        ]);

        return $memberPasswordReset;
    }

    protected function checkSpamForgotPassword(MemberPasswordReset $passwordReset): bool
    {
        return !Carbon::parse($passwordReset->updated_at)->addMinutes(MemberPasswordReset::TIME_DISTANCE)->isPast();
    }

    /**
     * @throws Exception
     */
    public function passwordReset(string $token): void
    {
        /** @var MemberPasswordReset $memberPasswordReset */
        $memberPasswordReset = app(MemberPasswordReset::class);
        $memberPasswordReset = MemberPasswordReset::query()->where('token', $token)->firstOrFail();

        $check = $this->checkTokenExpiration($memberPasswordReset->updated_at);
        if ($check) {
            throw new TokenExpirationException();
        }

        $password = MemberPasswordReset::makeRandPassword(8);

        /** @var MemberRepository $memberRepository */
        $memberRepository = app(MemberRepository::class);
        $member = $memberRepository->findByEmail($memberPasswordReset->email);
        $memberRepository->updatePassword($member, $password);

        Mail::to($member->email)->send(new PasswordReset($member, $password));

    }

    protected function checkTokenExpiration(string $passwordResetTime): bool
    {
        return Carbon::parse($passwordResetTime)->addMinutes(MemberPasswordReset::TOKEN_TIME)->isPast();
    }

}
