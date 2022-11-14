<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Member;
use Illuminate\Support\Facades\Hash;
use App\Models\Role;

class MemberTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $members = [
            [
                'password' => Hash::make('123123'),
                'email' => 'admin@test.com',
                'name' => 'admin',
                'gender' => true,
            ],
            [
                'password' => Hash::make('123123'),
                'email' => 'member1@test.com',
                'name' => 'member1',
                'gender' => true,
            ],
            [
                'password' => Hash::make('123123'),
                'email' => 'member2@test.com',
                'name' => 'member2',
                'gender' => true,
            ],
            [
                'password' => Hash::make('123123'),
                'email' => 'member3@test.com',
                'name' => 'member3',
                'gender' => true,
            ],
        ];

        foreach ($members as $member) {
            Member::query()->create($member);
        }

        # Set all role for admin
        $roleAdmin = Role::where('name', Role::ROLE_ADMIN)->first();
        $roleAdmin->members()->detach();

        $admin = Member::query()->where('id', config('env.admin_id'))->first();
        $admin->roles()->detach();
        $admin->roles()->attach($roleAdmin);

    }
}
