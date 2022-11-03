<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Member;
use Illuminate\Support\Facades\Hash;

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
                'username' => 'admin',
                'password' => Hash::make('123123'),
                'email' => 'admin@test.com',
                'name' => 'admin',
            ],
            [
                'username' => 'member1',
                'password' => Hash::make('123123'),
                'email' => 'member1@test.com',
                'name' => 'member1',
            ],
            [
                'username' => 'member2',
                'password' => Hash::make('123123'),
                'email' => 'member2@test.com',
                'name' => 'member2',
            ],
            [
                'username' => 'member3',
                'password' => Hash::make('123123'),
                'email' => 'member3@test.com',
                'name' => 'member3',
            ],
        ];

        foreach ($members as $member) {
            Member::query()->create($member);
        }
    }
}
