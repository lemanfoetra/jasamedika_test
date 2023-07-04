<?php

namespace Database\Seeders;

use App\Models\Menu as ModelsMenu;
use Illuminate\Database\Seeder;

class Menu extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ModelsMenu::insert(
            [
                [
                    'parrent_menu_id'   => 0,
                    'name'              => 'Dashboard',
                    'link'              => 'dashboard',
                    'urutan'            => 1,
                ],
                [
                    'parrent_menu_id'   => 0,
                    'name'              => 'Menu Management',
                    'link'              => 'menu',
                    'urutan'            => 2,
                ],
                [
                    'parrent_menu_id'   => 0,
                    'name'              => 'Role Management',
                    'link'              => 'role',
                    'urutan'            => 3,
                ],
                [
                    'parrent_menu_id'   => 0,
                    'name'              => 'User Management',
                    'link'              => 'user',
                    'urutan'            => 4,
                ]
            ]
        );
    }
}
