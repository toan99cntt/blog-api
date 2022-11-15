<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Hash;
use App\Models\Member;
use App\Base\BaseRepository;
use App\Filter\MemberFilter;
use App\Events\StoreMember;

class MemberRepository extends BaseRepository
{
    public function model(): string
    {
        return Member::class;
    }

    public function index(Request $request): Collection
    {
        $builder = $this->model->newQuery();
        /** @var MemberFilter $filter */
        $filter = app(MemberFilter::class);

        $filter->setData($request->all())->handle($builder);

        return $builder->get();
    }

    public function store(Request $request): Member
    {
        /** @var Member $member */
        $member = new $this->model();
        if ($request->hasFile('avatar')) {
            $member->addMedia($request->file('avatar'))->toMediaCollection(Member::AVATAR_MEMBER);
        }
        $member
            ->setEmail($request->get('email'))
            ->setPassword(Hash::make($request->get('password')))
            ->setName($request->get('name'))
            ->setStatus(Member::IS_ACTIVE)
            ->setGender($request->get('gender'))
            ->save();

        StoreMember::dispatch($member);

        return $member;
    }

    public function show($request, int $id): ?Member
    {
        $member = $this->model
            ->with(['blogs' => function($query) use ($request) {
                return $query->isPublish()
                    ->with(['likes' => function ($q) use ($request) {
                        $q->where('member_id', $request->user()->getKey());
                    }])
                    ;
            }])
            ->findOrFail($id);

        return $member;
    }

    public function update(Request $request, int $id): Member
    {
        /** @var Member $member */
        $member = $this->model->findOrFail($id);
        if ($request->hasFile('avatar')) {
            $member->clearMediaCollection(Member::AVATAR_MEMBER);
            $member->addMedia($request->file('avatar'))->toMediaCollection(Member::AVATAR_MEMBER);
        }
        $member
            ->setName($request->get('name'))
            ->setPhoneNumber($request->get('phone_number'))
            ->setDob(convert_date_vn_to_en($request->get('dob')))
            ->setGender($request->get('gender'))
            ->save();

        return $member;
    }

    public function findByEmail(string $email): ?Member
    {
        return $this->model->newQuery()->where('email', $email)->first();
    }

    public function updatePassword(Member $member, string $password): Member
    {
        $member->setPassword($password)
            ->save();

        return $member;
    }

    public function destroy(int $id): void
    {
        $this->model->newQuery()->findOrFail($id)->delete();
    }
}
