<?php

namespace Database\Seeders;

use App\Models\RoleAccess as ModelsRoleAccess;
use Illuminate\Database\Seeder;

class RoleAccess extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ModelsRoleAccess::insert(
            [
                [
                    'role_code' => 'superadmin',
                    'menu_id'   => '1',
                    'view'      => 'Y',
                    'create'    => 'Y',
                    'update'    => 'Y',
                    'delete'    => 'Y',
                ],
                [
                    'role_code' => 'superadmin',
                    'menu_id'   => '2',
                    'view'      => 'Y',
                    'create'    => 'Y',
                    'update'    => 'Y',
                    'delete'    => 'Y',
                ],
                [
                    'role_code' => 'superadmin',
                    'menu_id'   => '3',
                    'view'      => 'Y',
                    'create'    => 'Y',
                    'update'    => 'Y',
                    'delete'    => 'Y',
                ],
                [
                    'role_code' => 'superadmin',
                    'menu_id'   => '4',
                    'view'      => 'Y',
                    'create'    => 'Y',
                    'update'    => 'Y',
                    'delete'    => 'Y',
                ]
            ]
        );
    }
}
