<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // create administrator & user role
        Role::insert([
            [
                'id' => 1,
                'name' => 'Administrator',
                'slug' => 'admin'
            ],
            [
                'id' => 2,
                'name' => 'User',
                'slug' => 'user'
            ]
        ]);
    }
}
