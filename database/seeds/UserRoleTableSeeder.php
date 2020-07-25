<?php

use Illuminate\Database\Seeder;

class UserRoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            0 => 'Admin',
            1 => 'User',
        ];

        foreach ($roles as $role_id => $role_name) {
            $obj = new \App\UserRole();
            $obj->id = $role_id;
            $obj->name = $role_name;
            $obj->save();
        }
    }
}
