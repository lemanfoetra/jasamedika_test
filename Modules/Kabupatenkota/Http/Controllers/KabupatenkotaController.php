<?php

namespace Modules\Kabupatenkota\Http\Controllers;

use App\Models\Wilayah;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class KabupatenkotaController extends Controller
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
            'kabupatenkota::index',
            [
                'title'         => 'Master Wilayah Kabupaten / Kota',
                'breadcrumb' => [
                    ['title' => 'Home', 'link'      => ''],
                    ['title' => 'Master Wilayah', 'link'      => ''],
                    ['title' => 'Kabupaten / Kota', 'link' => route('kabupatenkota.index')]
                ]
            ]
        );
    }


    public function listProvinsi(Request $request)
    {
        $length = $request->length;
        $offset = $request->start;
        $search = $request->search['value'] ?? null;

        $lisData        = Wilayah::lists('2', $length, $offset, $search, 'wilayah_id');
        $totalData      = Wilayah::countList('2', $search);
        $totalFiltered  = $totalData;

        $data = [];
        foreach ($lisData as $index => $row) {
            $nestedData = [];

            $edit = "";
            if (permissionUpdate()) {
                $edit   = "<a href='" . url("kabupatenkota/edit/$row->wilayah_id") . "' class='btn btn-primary btn-sm'>Edit</a>";
            }

            $hapus = "";
            if (permissionDelete()) {
                $hapus  = "<a onclick='return confirm(`Yakin Hapus?`)' href='" . url("kabupatenkota/delete/$row->wilayah_id") . "' class='btn btn-danger btn-sm'>Hapus</a>";
            }

            $nestedData[] = "<center>" . (($offset) + ($index + 1)) . "</center>";
            $nestedData[] = $row->kode_kab;
            $nestedData[] = $row->nama_provinsi;
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
            'kabupatenkota::form',
            [
                'title'         => 'Tambah Kabupaten / Kota',
                'provinsies'    => Wilayah::provinsi(),
                'breadcrumb' => [
                    ['title' => 'Home', 'link'      => ''],
                    ['title' => 'Master Wilayah', 'link'      => ''],
                    ['title' => 'Kabupaten / Kota', 'link' => route('kabupatenkota.index')],
                    ['title' => 'Tambah Kabupaten / Kota', 'link' => route('kabupatenkota.create')]
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
        $provinsi = Wilayah::wilayah(['kode_pro'  => $request->kode_pro]);

        if ($request->wilayah_id != null) {
            Wilayah::where('wilayah_id', $request->wilayah_id)
                ->update([
                    'kode_pro'      => $provinsi->kode_pro,
                    'kode_kab'      => $request->kode_kab,
                    'nama'          => $request->nama,
                    'tingkat'       => '2',
                    'tingkat_label' => 'kabupaten',
                ]);
        } else {
            $wilayah = new Wilayah();
            $wilayah->kode_pro      = $provinsi->kode_pro;
            $wilayah->kode_kab      = $request->kode_kab;
            $wilayah->nama          = $request->nama;
            $wilayah->tingkat       = '2';
            $wilayah->tingkat_label = 'kabupaten';
            $wilayah->save();
        }
        return redirect()->to('kabupatenkota')->with('message_success', 'Berhasil disimpan.');
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
            'kabupatenkota::form',
            [
                'title'      => 'Edit Kabupaten / Kota',
                'data'       => $wilayah,
                'provinsies' => Wilayah::provinsi(),
                'breadcrumb' => [
                    ['title' => 'Home', 'link'      => ''],
                    ['title' => 'Master Wilayah', 'link'      => ''],
                    ['title' => 'Kabupaten / Kota', 'link' => route('kabupatenkota.index')],
                    ['title' => 'Edit Kabupaten / Kota', 'link' => route('kabupatenkota.edit', $id)]
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
        return redirect()->to('kabupatenkota')->with('message_success', 'Berhasil dihapus.');
    }
}
