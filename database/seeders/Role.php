<?php

namespace Database\Seeders;

use App\Models\Role as ModelsRole;
use Illuminate\Database\Seeder;

class Role extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ModelsRole::insert(
            [
                [
                    'role_code' => 'superadmin', 'name' => 'Super Admin'
                ],
                [
                    'role_code' => 'admin', 'name' => 'Admin'
                ],
                [
                    'role_code' => 'operator', 'name' => 'Operator'
                ]
            ]
        );
    }
}
