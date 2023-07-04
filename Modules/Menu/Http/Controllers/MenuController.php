<?php

namespace Modules\Menu\Http\Controllers;

use App\Models\Menu;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class MenuController extends Controller
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
        return view('menu::index', [
            'menus' => $this->listMenuSinggleArray(),
            'breadcrumb' => [
                [
                    'title' => 'Home', 'link' => ''
                ],
                [
                    'title' => 'Menu Managment', 'link' => route('menu.index'),
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
        return view('menu::form', [
            'title' => 'Tambah Menu',
            'menus' => $this->listMenu(),
            'breadcrumb' => [
                ['title' => 'Home', 'link' => ''],
                ['title' => 'Menu Managment', 'link' => route('menu.index')],
                ['title' => 'Create Menu', 'link' => route('menu.create')]
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $id = $request->id;
        if ($id != null) {
            Menu::where('id', $id)->update([
                'parrent_menu_id'   => $request->parrent_menu_id,
                'name'              => $request->name,
                'link'              => $request->link,
                'urutan'            => $request->urutan,
            ]);
        } else {
            Menu::create([
                'parrent_menu_id'   => $request->parrent_menu_id,
                'name'              => $request->name,
                'link'              => $request->link,
                'urutan'            => $request->urutan,
            ]);
        }
        return redirect(route('menu.index'))->with('message', 'Berhasil disimpan');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('menu::form', [
            'title' => 'Edit Menu',
            'menus' => $this->listMenu(),
            'data'  => Menu::find($id),
            'breadcrumb' => [
                ['title' => 'Home', 'link' => ''],
                ['title' => 'Menu Managment', 'link' => route('menu.index')],
                ['title' => 'Edit Menu', 'link' => route('menu.edit', $id)]
            ]
        ]);
    }


    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        Menu::where('id', $id)->delete();
        return redirect()->back();
    }


    protected function listMenu()
    {
        $listMenu = "";
        $menus = Menu::where('parrent_menu_id', '0')->orderBy('urutan', 'asc')->get();
        foreach ($menus as $menu) {
            if (Menu::isHaveChild($menu->id)) {
                $listMenu .= "<option value='$menu->id'>$menu->name</option>";
                $listMenu .= $this->getMenu($menu->id, '-');
            } else {
                $listMenu .= "<option value='$menu->id'>$menu->name</option>";
            }
        }
        return $listMenu;
    }


    protected function getMenu($id, $space = '')
    {
        $space .= "-";
        $listMenu = "";
        $menus = Menu::where('parrent_menu_id', $id)->orderBy('urutan', 'asc')->get();
        foreach ($menus as $menu) {
            if (Menu::isHaveChild($menu->id)) {
                $listMenu .= "<option value='$menu->id'>$space $menu->name</option>";
                $listMenu .= $this->getMenu($menu->id, ($space . '-'));
            } else {
                $listMenu .= "<option value='$menu->id'>$space $menu->name</option>";
            }
        }
        return $listMenu;
    }


    protected function listMenuSinggleArray()
    {
        $listMenu = [];
        $menus = Menu::where('parrent_menu_id', '0')->orderBy('urutan', 'asc')->get();
        foreach ($menus as $menu) {
            if (Menu::isHaveChild($menu->id)) {
                $listMenu = array_merge($listMenu, [[
                    'id'    => $menu->id,
                    'menu'  => $menu->name,
                    'link'  => $menu->link,
                    'urutan' => $menu->urutan,
                ]]);
                $listMenu = array_merge($listMenu, $this->getMenuSinggleArray($menu->id, '&nbsp; &nbsp;'));
            } else {
                $listMenu = array_merge($listMenu, [[
                    'id'    => $menu->id,
                    'menu'  => $menu->name,
                    'link'  => $menu->link,
                    'urutan' => $menu->urutan,
                ]]);
            }
        }
        return $listMenu;
    }


    protected function getMenuSinggleArray($id, $space = '')
    {
        $space .= "";
        $listMenu = [];
        $menus = Menu::where('parrent_menu_id', $id)->orderBy('urutan', 'asc')->get();
        foreach ($menus as $menu) {
            if (Menu::isHaveChild($menu->id)) {
                $listMenu = array_merge($listMenu, [[
                    'id'    => $menu->id,
                    'menu'  => $space . $menu->name,
                    'link'  => $menu->link,
                    'urutan' => $menu->urutan,
                ]]);
                $listMenu = array_merge($listMenu, $this->getMenuSinggleArray($menu->id, ($space . '&nbsp; &nbsp;')));
            } else {
                $listMenu = array_merge($listMenu, [[
                    'id'    => $menu->id,
                    'menu'  => $space . $menu->name,
                    'link'  => $menu->link,
                    'urutan' => $menu->urutan,
                ]]);
            }
        }
        return $listMenu;
    }
}
