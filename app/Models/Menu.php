<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Menu extends Model
{
    use HasFactory;
    protected $guarded = [];


    public static function isHaveChild($id)
    {
        $result = DB::table('menus')->select(['id'])
            ->where('parrent_menu_id', $id)
            ->first();
        if ($result != null) {
            return true;
        }
        return false;
    }


    public static function getChild($id)
    {
        return DB::table('menus')->select(['*'])
            ->where('parrent_menu_id', $id)
            ->get();
    }
}
