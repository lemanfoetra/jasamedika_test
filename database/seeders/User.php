<?php

namespace Database\Seeders;

use App\Models\User as ModelsUser;
use Illuminate\Database\Seeder;

class User extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ModelsUser::insert([
            [
                'name'          => "Super Admin",
                'email'         => "superadmin@mail.com",
                'role_code'     => "superadmin",
                'password'      => bcrypt('12345678')
            ],
            [
                'name'          => "Admin",
                'email'         => "admin@mail.com",
                'role_code'     => "admin",
                'password'      => bcrypt('12345678')
            ],
            [
                'name'          => "Operator",
                'email'         => "operator@mail.com",
                'role_code'     => "operator",
                'password'      => bcrypt('12345678')
            ]
        ]);
    }
}
