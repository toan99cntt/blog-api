<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\Member;

/**
 * @property integer id
 * @property string name
 * @property Collection members
 * @property integer created_at
 * @property integer updated_at
 */
class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    const ROLE_MEMBER = 'member';
    const ROLE_MANAGER = 'manager';
    const ROLE_ADMIN = 'admin';

    public function members(): BelongsToMany
    {
        return $this->belongsToMany(Member::class, 'member_role');
    }
}
