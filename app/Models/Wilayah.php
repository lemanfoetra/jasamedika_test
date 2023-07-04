<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Wilayah extends Model
{
    use HasFactory;

    protected $table        = "wilayahs";
    protected $primaryKey   = "wilayah_id";
    protected $guarded      = [];


    public static function lists($tingkat, $length, $start, $search = null, $orderBy = '')
    {
        $query =  DB::table("wilayahs")
            ->select(
                [
                    '*',
                    DB::raw("(  SELECT B.nama FROM wilayahs B WHERE B.kode_pro = wilayahs.kode_pro AND B.tingkat = '1' LIMIT 1 ) AS nama_provinsi"),
                    DB::raw("(  SELECT B.nama FROM wilayahs B WHERE B.kode_kab = wilayahs.kode_kab AND B.tingkat = '2' LIMIT 1 ) AS nama_kabupaten"),
                    DB::raw("(  SELECT B.nama FROM wilayahs B WHERE B.kode_kec = wilayahs.kode_kec AND B.tingkat = '3' LIMIT 1 ) AS nama_kecamatan"),
                ]
            );
        $query->where('tingkat', $tingkat);
        $query->whereNotIn('kode_pro', ['666', '999']);

        if ($search != null) {
            $query->where('nama', 'LIKE', "%$search%");
        }

        if ($orderBy != null) {
            $query->orderBy($orderBy, 'DESC');
        } else {
            $query->orderBy('kode_pro', 'asc');
        }
        $result = $query->limit($length)
            ->offset($start)
            ->get();
        return $result;
    }


    public static function countList($tingkat, $search = null)
    {
        $query =  DB::table('wilayahs')
            ->select(DB::raw("COUNT(wilayah_id) AS total"))
            ->where('tingkat', $tingkat);
        $query->whereNotIn('kode_pro', ['666', '999']);
        if ($search != null) {
            $query->where('nama', 'LIKE', "%$search%");
        }
        $result = $query->first();
        return $result->total;
    }


    public static function provinsi()
    {
        return  DB::table("wilayahs")->where('tingkat', '1')->get();
    }


    public static function kabupaten($kode_pro)
    {
        return  DB::table("wilayahs")
            ->where('tingkat', '2')
            ->where('kode_pro', $kode_pro)
            ->get();
    }


    public static function kecamatan($kode_kab)
    {
        return  DB::table("wilayahs")
            ->where('tingkat', '3')
            ->where('kode_kab', $kode_kab)
            ->get();
    }


    public static function kelurahan($kode_kec)
    {
        return  DB::table("wilayahs")
            ->where('tingkat', '4')
            ->where('kode_kec', $kode_kec)
            ->get();
    }


    public static function wilayah($where = [])
    {
        return  DB::table("wilayahs")->where($where)->first();
    }
}
