<?php

// For Helper

use App\Models\Menu;
use App\Models\Role;
use App\Models\RoleAccess;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;


function menuBuilder()
{
   $listMenu = '<ul class="horizontalMenu-list">';
   $menus = Menu::select(['menus.*'])
      ->where('menus.parrent_menu_id', '0')
      ->join('role_accesses', 'role_accesses.menu_id', 'menus.id')
      ->where('role_accesses.role_code', Auth::user()->role_code)
      ->orderBy('menus.urutan', 'asc')->get();
   foreach ($menus as $menu) {
      if (Menu::isHaveChild($menu->id)) {
         $listMenu .= '<li aria-haspopup="true">';
         $listMenu .= '<a href="' . url($menu->link ?? '#') . '" class="sub-icon">';
         $listMenu .= $menu->name;
         $listMenu .= '</a>';
         $listMenu .= __getMenu($menu->id);
         $listMenu .= '</li>';
      } else {
         $listMenu .= '<li aria-haspopup="true">';
         $listMenu .= '<a href="' . url($menu->link) . '" class="sub-icon">';
         $listMenu .= $menu->name;
         $listMenu .= '</a>';
         $listMenu .= '</li>';
      }
   }
   $listMenu .= '</ul>';
   return $listMenu;
}


function __getMenu($id)
{
   $listMenu = '<ul class="sub-menu">';
   $menus = Menu::select(['menus.*'])
      ->where('menus.parrent_menu_id', $id)
      ->join('role_accesses', 'role_accesses.menu_id', 'menus.id')
      ->where('role_accesses.role_code', Auth::user()->role_code)
      ->orderBy('menus.urutan', 'asc')->get();

   foreach ($menus as $menu) {
      if (Menu::isHaveChild($menu->id)) {
         $listMenu .= '<li aria-haspopup="true" class="sub-menu-sub">';
         $listMenu .= '<a href="' . url($menu->link ?? '#') . '" class="sub-icon">';
         $listMenu .= $menu->name;
         $listMenu .= '</a>';
         $listMenu .= __getMenu($menu->id,);
         $listMenu .= '</li>';
      } else {
         $listMenu .= '<li aria-haspopup="false" class="sub-menu">';
         $listMenu .= '<a href="' . url($menu->link) . '" class="sub-icon">';
         $listMenu .= $menu->name;
         $listMenu .= '</a>';
         $listMenu .= '</li>';
      }
   }
   $listMenu .= '</ul>';
   return $listMenu;
}


function accessThisMenu($menuUrl = 1, $url = null)
{
   $uri = Request::segment($menuUrl);
   if ($menuUrl === true) {
      $uri = $url;
   }
   $listRole   = "";
   $menu       = Menu::where('link', $uri)->first();
   $roles      = RoleAccess::where('menu_id', ($menu->id ?? ''))->get();
   foreach ($roles ?? [] as $key => $value) {
      if (($key + 1) < count($roles)) {
         $listRole .= $value->role->role_code . ',';
      } else {
         $listRole .= $value->role->role_code;
      }
   }
   return $listRole;
}

function __access($access, $uri)
{
   return RoleAccess::select(['role_accesses.*'])
      ->join('menus', 'menus.id', 'role_accesses.menu_id')
      ->join('roles', 'roles.role_code', 'role_accesses.role_code')
      ->where('menus.link', $uri)
      ->where($access, 'Y')
      ->where('roles.role_code', Auth::user()->role_code)
      ->first();
}


function permissionCreate($segment = 1)
{
   $uri  = Request::segment($segment);
   return (__access('create', $uri) !== null) ? true : false;
}


function permissionUpdate($segment = 1)
{
   $uri  = Request::segment($segment);
   return (__access('update', $uri) !== null) ? true : false;
}


function permissionDelete($segment = 1)
{
   $uri  = Request::segment($segment);
   return (__access('delete', $uri) !== null) ? true : false;
}
