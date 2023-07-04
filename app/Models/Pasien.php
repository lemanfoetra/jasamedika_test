<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Pasien extends Model
{
    use HasFactory;
    protected $guarded = [];


    public static function lists($length, $start, $search = null)
    {
        $query =  DB::table("pasiens")
            ->select(
                [
                    '*',
                    DB::raw("(  SELECT B.nama FROM wilayahs B WHERE B.kode_kel = pasiens.kode_kel AND B.tingkat = '4' LIMIT 1 ) AS nama_kelurahan"),
                ]
            );
        if ($search != null) {
            $search = addslashes("%$search%");
            $search = "'$search'";
            $query->where(DB::raw("
            (   nama LIKE $search
                OR id_pasien LIKE $search
                OR no_telp LIKE $search
                OR alamat LIKE $search
                OR tgl_lahir LIKE $search
            )"));
        }

        $query->orderBy('id', 'DESC');
        $result = $query->limit($length)
            ->offset($start)
            ->get();
        return $result;
    }


    public static function countList($search = null)
    {
        $query =  DB::table('pasiens')
            ->select(DB::raw("COUNT(id) AS total"));

        if ($search != null) {
            $search = addslashes("%$search%");
            $search = "'$search'";
            $query->where(DB::raw("
                (   nama LIKE $search
                    OR id_pasien LIKE $search
                    OR no_telp LIKE $search
                    OR alamat LIKE $search
                    OR tgl_lahir LIKE $search
                )"));
        }
        $result = $query->first();
        return $result->total;
    }



    public static function generateID()
    {
        $old = DB::table('pasiens')
            ->select(['id_pasien'])
            ->orderBy('id', 'desc')
            ->limit('1')
            ->first();
        if ($old == null) {
            return date('ym') . "000001";
        }

        (int)$oldNumber = substr($old->id_pasien, 4, 100);
        $oldNumber++;

        $newNumber = "";
        for ($i = 0; $i < (6 - strlen($oldNumber)); $i++) {
            $newNumber .= "0";
        }

        return date('ym') . $newNumber . $oldNumber;
    }
}
