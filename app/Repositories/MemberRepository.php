<?php

namespace App\Repositories;

use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use App\Base\BaseRepository;
use Illuminate\Support\Facades\Hash;

class MemberRepository extends BaseRepository
{
    public function model(): string
    {
        return Member::class;
    }

    public function index(Request $request): Collection
    {
        return $this->model->newQuery()->get();
    }

    public function store(Request $request): Member
    {
        /** @var Member $member */
        $member = new $this->model();
        $member
            ->setEmail($request->get('email'))
            ->setPassword(Hash::make($request->get('password')))
            ->setName($request->get('name'))
            ->setStatus(Member::INACTIVE)
            ->save();

        return $member;
    }

    public function show(int $id): ?Member
    {
        $blog = $this->model->with('blogs')->findOrFail($id);
        return $blog;
    }

    public function update(Request $request, int $id): Member
    {
        /** @var Member $member */
        $member = $this->model->findOrFail($id);
        if ($request->hasFile('avatar')) {
            $member->addMedia($request->file('avatar'))->toMediaCollection(Member::AVATAR_MEMBER);
        }
        $member
            ->setName($request->get('name'))
            ->setPhoneNumber($request->get('phone_number'))
            ->setDob($request->get('dob'))
            ->save();

        return $member;
    }
}
