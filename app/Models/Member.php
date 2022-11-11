<?php

namespace App\Models;

use Laravel\Passport\HasApiTokens;
use Illuminate\Foundation\Auth\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Collection;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use App\Models\Blog;
use App\Models\Role;

/**
 * @property integer id
 * @property string dob
 * @property string name
 * @property string password
 * @property string email
 * @property string phone_number
 * @property integer status
 * @property bool gender
 * @property Collection blogs
 * @property Collection comments
 * @property Collection roles
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
        'gender',
        'dob',
    ];

    const IS_ACTIVE = 1;
    const INACTIVE = 0;

    const MALE = true;
    const FE_MALE = false;

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

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'member_role');
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function setPassword(?string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function setPhoneNumber(?string $phoneNumber): self
    {
        $this->phone_number = $phoneNumber;

        return $this;
    }

    public function setStatus(?int $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function setGender(?bool $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    public function setDob(?string $dob): self
    {
        $this->dob = $dob;

        return $this;
    }

    public function isAdmin(): bool
    {
        return $this->roles->contains([Role::ROLE_ADMIN]);
    }

    public function isManager(): bool
    {
        return $this->roles->contains([Role::ROLE_MANAGER]);
    }

    public function isMember(): bool
    {
        return $this->roles->contains([Role::ROLE_MEMBER]);
    }

    public function checkRoleIn(array $rolesId): bool
    {
        return $this->roles()->whereIn('role_id', $rolesId)->exists();
    }

}
