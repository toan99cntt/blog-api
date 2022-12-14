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
            ->setEmail($request->get('_email'))
            ->setPassword(Hash::make($request->get('_password')))
            ->setName($request->get('_name'))
            ->setStatus(Member::IS_ACTIVE)
            ->setGender($request->get('_gender'))
            ->setPhoneNumber($request->get('_phone_number'))
            ->setDob(convert_date_vn_to_en($request->get('_dob')))
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
            return $member;
        }
        if($request->get('_password')) {
            $member->setPassword(Hash::make($request->get('_password')));
        }
        // dd($request->get('_gender'));
        $member
            ->setName($request->get('_name'))
            ->setPhoneNumber($request->get('_phone_number'))
            ->setDob(convert_date_vn_to_en($request->get('_dob')))
            ->setGender($request->get('_gender'))
            ->save();

        return $member;
    }

    public function findByEmail(string $email): ?Member
    {
        return $this->model->newQuery()->where('email', $email)->first();
    }

    public function findByIds(array $ids): Collection
    {
        return $this->model->newQuery()->whereIn('id', $ids)->get();
    }

    public function updatePassword(Member $member, string $password): Member
    {
        $member->setPassword(Hash::make($password))
            ->save();

        return $member;
    }

    public function destroy(int $id): void
    {
        $this->model->newQuery()->findOrFail($id)->delete();
    }
}
