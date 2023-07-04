<?php

namespace Modules\Provinsi\Http\Controllers;

use App\Models\Wilayah;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ProvinsiController extends Controller
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
            'provinsi::index',
            [
                'title'         => 'Master Wilayah Provinsi',
                'breadcrumb' => [
                    ['title' => 'Home', 'link'      => ''],
                    ['title' => 'Master Wilayah', 'link'      => ''],
                    ['title' => 'Provinsi', 'link' => route('provinsi.index')]
                ]
            ]
        );
    }


    public function listProvinsi(Request $request)
    {
        $length = $request->length;
        $offset = $request->start;
        $search = $request->search['value'] ?? null;

        $lisData        = Wilayah::lists('1', $length, $offset, $search);
        $totalData      = Wilayah::countList('1', $search);
        $totalFiltered  = $totalData;

        $data = [];
        foreach ($lisData as $index => $row) {
            $nestedData = [];

            $edit = "";
            if (permissionUpdate()) {
                $edit   = "<a href='" . url("provinsi/edit/$row->wilayah_id") . "' class='btn btn-primary btn-sm'>Edit</a>";
            }

            $hapus = "";
            if (permissionDelete()) {
                $hapus  = "<a onclick='return confirm(`Yakin Hapus?`)' href='" . url("provinsi/delete/$row->wilayah_id") . "' class='btn btn-danger btn-sm'>Hapus</a>";
            }

            $nestedData[] = "<center>" . (($offset) + ($index + 1)) . "</center>";
            $nestedData[] = $row->kode_pro;
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
            'provinsi::form',
            [
                'title' => 'Tambah Provinsi',
                'breadcrumb' => [
                    ['title' => 'Home', 'link'      => ''],
                    ['title' => 'Master Wilayah', 'link'      => ''],
                    ['title' => 'Provinsi', 'link' => route('provinsi.index')],
                    ['title' => 'Tambah Provinsi', 'link' => route('provinsi.create')]
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
                    'nama'          => $request->nama,
                    'tingkat'       => '1',
                    'tingkat_label' => 'provinsi',
                ]);
        } else {
            $wilayah = new Wilayah();
            $wilayah->kode_pro      = $request->kode_pro;
            $wilayah->nama          = $request->nama;
            $wilayah->tingkat       = '1';
            $wilayah->tingkat_label = 'provinsi';
            $wilayah->save();
        }
        return redirect()->to('provinsi')->with('message_success', 'Berhasil disimpan.');
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
            'provinsi::form',
            [
                'title'      => 'Edit Provinsi',
                'data'       => $wilayah,
                'breadcrumb' => [
                    ['title' => 'Home', 'link'      => ''],
                    ['title' => 'Master Wilayah', 'link'      => ''],
                    ['title' => 'Provinsi', 'link' => route('provinsi.index')],
                    ['title' => 'Edit Provinsi', 'link' => route('provinsi.edit', $id)]
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
        return redirect()->to('provinsi')->with('message_success', 'Berhasil dihapus.');
    }
}
