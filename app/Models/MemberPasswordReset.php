<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;

/**
 * @property int id
 * @property string email
 * @property string token
 * @property int created_at
 * @property int updated_at
 */
class MemberPasswordReset extends Model
{
    use HasFactory;

    protected $table = 'member_password_resets';

    protected $fillable = [
        'email',
        'token'
    ];

    const TOKEN_LENGTH = 30;
    const PASSWORD_LENGTH = 8;
    const PASSWORD_MIN_LENGTH = 8;
    const TIME_DISTANCE = 5;
    const TOKEN_TIME = 30;

    public static function makeRandPassword(int $length = self::PASSWORD_MIN_LENGTH): string
    {
        if ($length < self::PASSWORD_MIN_LENGTH) {
            $length = self::PASSWORD_MIN_LENGTH;
        }
        $randomString = Str::random($length - 4);
        $lowercase = Arr::random(range('a', 'z'));
        $digits = Arr::random(range('0', '9'));
        $uppercase = Arr::random(range('A', 'Z'));
        $special = Arr::random(['#', '?', '!', '@', '$', '%', '^', '&', '*', '-']);

        return $randomString . $lowercase . $digits . $uppercase . $special;
    }
}
