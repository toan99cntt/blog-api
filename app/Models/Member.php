<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Blog;

/**
 * @property integer id
 * @property string dob
 * @property string name
 * @property string password
 * @property string email
 * @property string phone_number
 * @property integer status
 * @property Collection blogs
 * @property integer created_at
 * @property integer updated_at
 */
class Member extends User implements HasMedia
{
    use HasFactory, HasApiTokens, SoftDeletes, InteractsWithMedia;

    protected $fillable = [
        'email',
        'password',
        'name',
        'phone_number',
        'status',
        'dob',
    ];

    const IS_ACTIVE = 1;
    const INACTIVE = 0;

    const AVATAR_MEMBER = 'avatar_member';

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'deleted_at',
    ];

    public function findForPassport(string $username): ?Member
    {
        $member = $this->newQuery()->where('email', $username)->first();

        if (!$member) {
            return null;
        }

        return $member;
    }

    public function blogs(): HasMany
    {
        return $this->hasMany(Blog::class);
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function setPhoneNumber(?string $phoneNumber): self
    {
        $this->phone_number = $phoneNumber;

        return $this;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function setDob(string $dob): self
    {
        $this->dob = $dob;

        return $this;
    }
}
