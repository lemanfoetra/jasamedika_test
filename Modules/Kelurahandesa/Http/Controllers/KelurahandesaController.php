<?php

namespace Modules\Kelurahandesa\Http\Controllers;

use App\Models\Wilayah;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class KelurahandesaController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
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
        return view(
            'kelurahandesa::index',
            [
                'title'         => 'Master Wilayah Kelurahan / Desa',
                'breadcrumb' => [
                    ['title' => 'Home', 'link'      => ''],
                    ['title' => 'Master Wilayah', 'link'      => ''],
                    ['title' => 'Kelurahan / Desa', 'link' => route('kelurahandesa.index')]
                ]
            ]
        );
    }


    public function listDesa(Request $request)
    {
        $length = $request->length;
        $offset = $request->start;
        $search = $request->search['value'] ?? null;

        $lisData        = Wilayah::lists('4', $length, $offset, $search, 'wilayah_id');
        $totalData      = Wilayah::countList('4', $search);
        $totalFiltered  = $totalData;

        $data = [];
        foreach ($lisData as $index => $row) {
            $nestedData = [];

            $edit = "";
            if (permissionUpdate()) {
                $edit   = "<a href='" . url("kelurahandesa/edit/$row->wilayah_id") . "' class='btn btn-primary btn-sm'>Edit</a>";
            }

            $hapus = "";
            if (permissionDelete()) {
                $hapus  = "<a onclick='return confirm(`Yakin Hapus?`)' href='" . url("kelurahandesa/delete/$row->wilayah_id") . "' class='btn btn-danger btn-sm'>Hapus</a>";
            }

            $nestedData[] = "<center>" . (($offset) + ($index + 1)) . "</center>";
            $nestedData[] = $row->kode_kel;
            $nestedData[] = $row->nama_provinsi;
            $nestedData[] = $row->nama_kabupaten;
            $nestedData[] = $row->nama_kecamatan;
            $nestedData[] = $row->nama;
            $nestedData[] = "<center>$edit $hapus</center>";

            $data[] = $nestedData;
        }

        $json_data = array(
            "draw"            => intval($request->draw),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $data
        );
        return json_encode($json_data);
    }


    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view(
            'kelurahandesa::form',
            [
                'title'         => 'Tambah Kelurahan / Desa',
                'provinsies'    => Wilayah::provinsi(),
                'breadcrumb' => [
                    ['title' => 'Home', 'link'      => ''],
                    ['title' => 'Master Wilayah', 'link'      => ''],
                    ['title' => 'Kelurahan / Desa', 'link' => route('kelurahandesa.index')],
                    ['title' => 'Tambah Kelurahan / Desa', 'link' => route('kelurahandesa.create')]
                ]
            ]
        );
    }


    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        if ($request->wilayah_id != null) {
            Wilayah::where('wilayah_id', $request->wilayah_id)
                ->update([
                    'kode_pro'      => $request->kode_pro,
                    'kode_kab'      => $request->kode_kab,
                    'kode_kec'      => $request->kode_kec,
                    'kode_kel'      => $request->kode_kel,
                    'nama'          => $request->nama,
                    'tingkat'       => '4',
                    'tingkat_label' => 'kelurahan',
                ]);
        } else {
            $wilayah = new Wilayah();
            $wilayah->kode_pro      = $request->kode_pro;
            $wilayah->kode_kab      = $request->kode_kab;
            $wilayah->kode_kec      = $request->kode_kec;
            $wilayah->kode_kel      = $request->kode_kel;
            $wilayah->nama          = $request->nama;
            $wilayah->tingkat       = '4';
            $wilayah->tingkat_label = 'kelurahan';
            $wilayah->save();
        }
        return redirect()->to('kelurahandesa')->with('message_success', 'Berhasil disimpan.');
    }


    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $wilayah = Wilayah::find($id);

        return view(
            'kelurahandesa::form',
            [
                'title'      => 'Edit Kelurahan / Desa',
                'data'       => $wilayah,
                'provinsies' => Wilayah::provinsi(),
                'breadcrumb' => [
                    ['title' => 'Home', 'link'      => ''],
                    ['title' => 'Master Wilayah', 'link'      => ''],
                    ['title' => 'Kelurahan / Desa', 'link' => route('kelurahandesa.index')],
                    ['title' => 'Edit Kelurahan / Desa', 'link' => route('kelurahandesa.edit', $id)]
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
        Wilayah::where('wilayah_id', $id)->delete();
        return redirect()->to('kelurahandesa')->with('message_success', 'Berhasil dihapus.');
    }


    public function list_kab(Request $request)
    {
        $listKab = Wilayah::kabupaten($request->kode_pro);
        return view(
            'kelurahandesa::list_kab',
            [
                'kode_kab'     => $request->kode_kab ?? '',
                'listKab'      => $listKab,
            ]
        );
    }


    public function list_kec(Request $request)
    {
        $listKec = Wilayah::kecamatan($request->kode_kab);
        return view(
            'kelurahandesa::list_kec',
            [
                'kode_kec'     => $request->kode_kec ?? '',
                'listKec'      => $listKec,
            ]
        );
    }
}
