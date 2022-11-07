<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Member;
use App\Models\MemberPasswordReset;

class ForgotPassword extends Mailable
{
    use Queueable, SerializesModels;

    private Member $member;
    private MemberPasswordReset $memberPasswordReset;
    private array $info;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(MemberPasswordReset $memberPasswordReset, Member $member, array $info)
    {
        $this->memberPasswordReset = $memberPasswordReset;
        $this->member = $member;
        $this->info = $info;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.auth.forgot_password')
            ->with([
                'url' => route('auth.password_reset', ['token' => $this->memberPasswordReset->token]),
                'urlLifeTime' => MemberPasswordReset::TOKEN_TIME,
                'user' => $this->member,
                'info' => $this->info,
                'passwordReset' => $this->memberPasswordReset,
            ])
            ->subject('Yêu cầu tạo lại mật khẩu');
    }
}
