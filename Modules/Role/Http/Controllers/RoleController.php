<?php

namespace Modules\Role\Http\Controllers;

use App\Models\Menu;
use App\Models\Role;
use App\Models\RoleAccess;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Role\Http\Requests\AddRoleRequest;

class RoleController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth.role:' . accessThisMenu());
    }


    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('role::index', [
            'datas' => Role::all(),
            'breadcrumb' => [
                [
                    'title' => 'Home', 'link' => ''
                ],
                [
                    'title' => 'Role Managment', 'link' => route('role.index'),
                ]
            ]
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view(
            'role::form',
            [
                'title' => 'Tambah Role',
                'breadcrumb' => [
                    [
                        'title' => 'Home', 'link' => ''
                    ],
                    [
                        'title' => 'Role Management', 'link' => route('role.index'),
                    ],
                    [
                        'title' => 'Tambah Role', 'link' => '',
                    ]
                ]
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(AddRoleRequest $request)
    {
        $id     = $request->id;
        $data   = [
            'role_code' => $request->role_code,
            'name'      => $request->name,
        ];
        if ($id != null) {
            Role::where('id', $id)->update($data);
        } else {
            Role::create($data);
        }
        return redirect(url('role'))->with('message', 'Data has been saved.');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view(
            'role::form',
            [
                'data'  => Role::find($id),
                'title' => 'Edit Role',
                'breadcrumb' => [
                    [
                        'title' => 'Home', 'link' => ''
                    ],
                    [
                        'title' => 'Role Management', 'link' => route('role.index'),
                    ],
                    [
                        'title' => 'Edit Role', 'link' => '',
                    ]
                ]
            ]
        );
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        Role::where('id', $id)->delete();
        return redirect(url('role'))->with('message', 'Data has been deleted.');
    }


    public function accessMenu(Role $role)
    {
        return view(
            'role::access',
            [
                'role'  => $role,
                'title' => 'Access Role',
                'menus' => $this->listMenuSinggleArray($role->role_code),
                'breadcrumb' => [
                    [
                        'title' => 'Home', 'link' => ''
                    ],
                    [
                        'title' => 'Role Managment', 'link' => route('role.index'),
                    ],
                    [
                        'title' => 'Access Role', 'link' => '',
                    ]
                ]
            ]
        );
    }


    public function setAccess(Request $request)
    {
        if ($request->flag == 'menu') {
            if ($request->checked === 'true') {
                RoleAccess::updateOrCreate(['role_code' => $request->role_code, 'menu_id' => $request->menu_id]);
            } else {
                RoleAccess::where('role_code', $request->role_code)
                    ->where('menu_id', $request->menu_id)
                    ->delete();
            }
        } else if ($request->flag == 'create') {
            if ($request->checked === 'true') {
                RoleAccess::where('role_code', $request->role_code)
                    ->where('menu_id', $request->menu_id)
                    ->update(['create' => 'Y']);
            } else {
                RoleAccess::where('role_code', $request->role_code)
                    ->where('menu_id', $request->menu_id)
                    ->update(['create' => null]);
            }
        } else if ($request->flag == 'update') {
            if ($request->checked === 'true') {
                RoleAccess::where('role_code', $request->role_code)
                    ->where('menu_id', $request->menu_id)
                    ->update(['update' => 'Y']);
            } else {
                RoleAccess::where('role_code', $request->role_code)
                    ->where('menu_id', $request->menu_id)
                    ->update(['update' => null]);
            }
        } else if ($request->flag == 'delete') {
            if ($request->checked === 'true') {
                RoleAccess::where('role_code', $request->role_code)
                    ->where('menu_id', $request->menu_id)
                    ->update(['delete' => 'Y']);
            } else {
                RoleAccess::where('role_code', $request->role_code)
                    ->where('menu_id', $request->menu_id)
                    ->update(['delete' => null]);
            }
        }
    }


    protected function listMenuSinggleArray($role_code)
    {
        $listMenu = [];
        $menus = Menu::select([
            'menus.*', 
            'role_accesses.id AS access_id',
            'role_accesses.view', 
            'role_accesses.create', 
            'role_accesses.update', 
            'role_accesses.delete'
        ])
            ->where('menus.parrent_menu_id', '0')
            ->leftJoin('role_accesses', function ($join) use ($role_code) {
                $join->on('role_accesses.menu_id', '=', 'menus.id');
                $join->on('role_accesses.role_code', '=', DB::raw("'" . $role_code . "'"));
            })
            ->orderBy('menus.urutan', 'asc')->get();
        foreach ($menus as $menu) {
            if (Menu::isHaveChild($menu->id)) {
                $listMenu = array_merge($listMenu, [[
                    'id'    => $menu->id,
                    'menu'  => $menu->name,
                    'link'  => $menu->link,
                    'urutan' => $menu->urutan,
                    'access_id' => $menu->access_id,
                    'view'   => $menu->view,
                    'create' => $menu->create,
                    'update' => $menu->update,
                    'delete' => $menu->delete,
                ]]);
                $listMenu = array_merge($listMenu, $this->getMenuSinggleArray($role_code, $menu->id, ' - - '));
            } else {
                $listMenu = array_merge($listMenu, [[
                    'id'    => $menu->id,
                    'menu'  => $menu->name,
                    'link'  => $menu->link,
                    'urutan' => $menu->urutan,
                    'access_id' => $menu->access_id,
                    'view'   => $menu->view,
                    'create' => $menu->create,
                    'update' => $menu->update,
                    'delete' => $menu->delete,
                ]]);
            }
        }
        return $listMenu;
    }


    protected function getMenuSinggleArray($role_code, $id, $space = '')
    {
        $space .= "";
        $listMenu = [];
        $menus = Menu::select(['menus.*', 'role_accesses.id AS access_id', 'role_accesses.view', 'role_accesses.create', 'role_accesses.update', 'role_accesses.delete'])
            ->where('menus.parrent_menu_id', $id)
            ->leftJoin('role_accesses', function ($join) use ($role_code) {
                $join->on('role_accesses.menu_id', '=', 'menus.id');
                $join->on('role_accesses.role_code', '=', DB::raw("'" . $role_code . "'"));
            })
            ->orderBy('menus.urutan', 'asc')->get();
        foreach ($menus as $menu) {
            if (Menu::isHaveChild($menu->id)) {
                $listMenu = array_merge($listMenu, [[
                    'id'    => $menu->id,
                    'menu'  => $space . $menu->name,
                    'link'  => $menu->link,
                    'urutan' => $menu->urutan,
                    'access_id' => $menu->access_id,
                    'view'   => $menu->view,
                    'create' => $menu->create,
                    'update' => $menu->update,
                    'delete' => $menu->delete,
                ]]);
                $listMenu = array_merge($listMenu, $this->getMenuSinggleArray($role_code, $menu->id, ($space . ' - - ')));
            } else {
                $listMenu = array_merge($listMenu, [[
                    'id'    => $menu->id,
                    'menu'  => $space . $menu->name,
                    'link'   => $menu->link,
                    'urutan' => $menu->urutan,
                    'access_id' => $menu->access_id,
                    'view'   => $menu->view,
                    'create' => $menu->create,
                    'update' => $menu->update,
                    'delete' => $menu->delete,
                ]]);
            }
        }
        return $listMenu;
    }
}
