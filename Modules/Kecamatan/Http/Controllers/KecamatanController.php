<?php

namespace Modules\Kecamatan\Http\Controllers;

use App\Models\Wilayah;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class KecamatanController extends Controller
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
            'kecamatan::index',
            [
                'title'         => 'Master Wilayah Kecamatan',
                'breadcrumb' => [
                    ['title' => 'Home', 'link'      => ''],
                    ['title' => 'Master Wilayah', 'link'      => ''],
                    ['title' => 'Kecamatan', 'link' => route('kecamatan.index')]
                ]
            ]
        );
    }


    public function listKecamatan(Request $request)
    {
        $length = $request->length;
        $offset = $request->start;
        $search = $request->search['value'] ?? null;

        $lisData        = Wilayah::lists('3', $length, $offset, $search, 'wilayah_id');
        $totalData      = Wilayah::countList('3', $search);
        $totalFiltered  = $totalData;

        $data = [];
        foreach ($lisData as $index => $row) {
            $nestedData = [];

            $edit = "";
            if (permissionUpdate()) {
                $edit   = "<a href='" . url("kecamatan/edit/$row->wilayah_id") . "' class='btn btn-primary btn-sm'>Edit</a>";
            }

            $hapus = "";
            if (permissionDelete()) {
                $hapus  = "<a onclick='return confirm(`Yakin Hapus?`)' href='" . url("kecamatan/delete/$row->wilayah_id") . "' class='btn btn-danger btn-sm'>Hapus</a>";
            }

            $nestedData[] = "<center>" . (($offset) + ($index + 1)) . "</center>";
            $nestedData[] = $row->kode_kec;
            $nestedData[] = $row->nama_provinsi;
            $nestedData[] = $row->nama_kabupaten;
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
            'kecamatan::form',
            [
                'title'         => 'Tambah Kecamatan',
                'provinsies'    => Wilayah::provinsi(),
                'breadcrumb' => [
                    ['title' => 'Home', 'link'      => ''],
                    ['title' => 'Master Wilayah', 'link'      => ''],
                    ['title' => 'Kecamatan', 'link' => route('kecamatan.index')],
                    ['title' => 'Tambah Kecamatan', 'link' => route('kecamatan.create')]
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
        $kabupaten  = Wilayah::wilayah(['kode_kab' => $request->kode_kab]);
        $provinsi   = Wilayah::wilayah(['kode_pro'  => $kabupaten->kode_pro]);

        if ($request->wilayah_id != null) {
            Wilayah::where('wilayah_id', $request->wilayah_id)
                ->update([
                    'kode_pro'      => $provinsi->kode_pro,
                    'kode_kab'      => $kabupaten->kode_kab,
                    'kode_kec'      => $request->kode_kec,
                    'nama'          => $request->nama,
                    'tingkat'       => '3',
                    'tingkat_label' => 'kecamatan',
                ]);
        } else {
            $wilayah = new Wilayah();
            $wilayah->kode_pro      = $provinsi->kode_pro;
            $wilayah->kode_kab      = $kabupaten->kode_kab;
            $wilayah->kode_kec      = $request->kode_kec;
            $wilayah->nama          = $request->nama;
            $wilayah->tingkat       = '3';
            $wilayah->tingkat_label = 'kecamatan';
            $wilayah->save();
        }
        return redirect()->to('kecamatan')->with('message_success', 'Berhasil disimpan.');
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
            'kecamatan::form',
            [
                'title'      => 'Edit Kecamatan',
                'data'       => $wilayah,
                'provinsies' => Wilayah::provinsi(),
                'breadcrumb' => [
                    ['title' => 'Home', 'link'      => ''],
                    ['title' => 'Master Wilayah', 'link'      => ''],
                    ['title' => 'Kecamatan', 'link' => route('kecamatan.index')],
                    ['title' => 'Edit Kecamatan', 'link' => route('kecamatan.edit', $id)]
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
        return redirect()->to('kecamatan')->with('message_success', 'Berhasil dihapus.');
    }


    public function list_kab(Request $request)
    {
        $listKab = Wilayah::kabupaten($request->kode_pro);
        return view(
            'kecamatan::list_kab',
            [
                'kode_kab'     => $request->kode_kab ?? '',
                'listKab'      => $listKab,
            ]
        );
    }
}
