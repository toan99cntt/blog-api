<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            [
                'name' => 'admin'
            ],
            [
                'name' => 'manager'
            ],
            [
                'name' => 'member'
            ],
        ];

        foreach ($roles as $role) {
            Role::updateOrCreate($role, $role);
        }
    }
}
