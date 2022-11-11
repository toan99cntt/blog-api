<?php

namespace App\Repositories;

use App\Models\Role;
use App\Base\BaseRepository;
use App\Models\Member;
use Illuminate\Database\Eloquent\Collection;

class RoleRepository extends BaseRepository
{
    public function model(): string
    {
        return Role::class;
    }

    public function setDefaultRole(Member $member): void
    {
        $defaultRole = $this->model->newQuery()->where('name', Role::ROLE_MEMBER)->firstOrFail();

        $member->roles()->attach($defaultRole->getKey());
    }

    public function findByNames(array $names): Collection
    {
        $roles = $this->model->newQuery()->whereIn('name', $names)->get();

        return $roles;
    }
}
