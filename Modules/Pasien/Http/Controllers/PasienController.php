<?php

namespace Modules\Pasien\Http\Controllers;

use App\Models\Pasien;
use App\Models\Wilayah;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class PasienController extends Controller
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
            'pasien::index',
            [
                'title'         => 'Pasien',
                'breadcrumb' => [
                    ['title' => 'Home', 'link'      => ''],
                    ['title' => 'Pasien', 'link' => route('pasien.index')]
                ]
            ]
        );
    }


    public function listPasien(Request $request)
    {
        $length = $request->length;
        $offset = $request->start;
        $search = $request->search['value'] ?? null;

        $lisData        = Pasien::lists($length, $offset, $search);
        $totalData      = Pasien::countList($search);
        $totalFiltered  = $totalData;

        $data = [];
        foreach ($lisData as $index => $row) {
            $nestedData = [];

            $edit = "";
            if (permissionUpdate()) {
                $edit   = "<a href='" . url("pasien/edit/$row->id") . "' class='btn btn-primary btn-sm'>Edit</a>";
            }

            $hapus = "";
            if (permissionDelete()) {
                $hapus  = "<a onclick='return confirm(`Yakin Hapus?`)' href='" . url("pasien/delete/$row->id") . "' class='btn btn-danger btn-sm'>Hapus</a>";
            }

            $nestedData[] = "<center>" . (($offset) + ($index + 1)) . "</center>";
            $nestedData[] = $row->id_pasien;
            $nestedData[] = $row->nama;
            $nestedData[] = $row->no_telp;
            $nestedData[] = $row->alamat;
            $nestedData[] = $row->nama_kelurahan;
            $nestedData[] = $row->rt . " / " . $row->rw;
            $nestedData[] = $row->tgl_lahir;
            $nestedData[] = ($row->jenis_kelamin == 'L') ? 'Laki-laki' : 'Perempuan';
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
            'pasien::form',
            [
                'title'         => 'Tambah Pasien',
                'provinsies'    => Wilayah::provinsi(),
                'breadcrumb' => [
                    ['title' => 'Home', 'link'      => ''],
                    ['title' => 'Pasien', 'link' => route('pasien.index')],
                    ['title' => 'Tambah Pasien', 'link' => route('pasien.create')]
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
        $data = [
            'nama'          => $request->nama,
            'no_telp'       => $request->no_telp,
            'kode_pro'      => $request->kode_pro,
            'kode_kab'      => $request->kode_kab,
            'kode_kec'      => $request->kode_kec,
            'kode_kel'      => $request->kode_kel,
            'alamat'        => $request->alamat,
            'rt'            => $request->rt,
            'rw'            => $request->rw,
            'tgl_lahir'     => $request->tgl_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'updated_at'    => date('Y-m-d H:i:s'),
        ];

        if ($request->id != null) {
            Pasien::where('id', $request->id)
                ->update($data);
        } else {
            $data['id_pasien']   = Pasien::generateID();
            $data['created_at']  = date('Y-m-d H:i:s');
            Pasien::insert($data);
        }
        return redirect()->to('pasien')->with('message_success', 'Berhasil disimpan.');
    }


    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view(
            'pasien::form',
            [
                'title'      => 'Edit Pasien',
                'data'       => Pasien::find($id),
                'provinsies' => Wilayah::provinsi(),
                'breadcrumb' => [
                    ['title' => 'Home', 'link'      => ''],
                    ['title' => 'Pasien', 'link' => route('pasien.index')],
                    ['title' => 'Edit Pasien', 'link' => route('pasien.edit', $id)]
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
        Pasien::where('id', $id)->delete();
        return redirect()->to('pasien')->with('message_success', 'Berhasil dihapus.');
    }


    public function list_kab(Request $request)
    {
        $listKab = Wilayah::kabupaten($request->kode_pro);
        return view(
            'pasien::list_kab',
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
            'pasien::list_kec',
            [
                'kode_kec'     => $request->kode_kec ?? '',
                'listKec'      => $listKec,
            ]
        );
    }


    public function list_kel(Request $request)
    {
        $listKec = Wilayah::kelurahan($request->kode_kec);
        return view(
            'pasien::list_kel',
            [
                'kode_kel'     => $request->kode_kel ?? '',
                'listKec'      => $listKec,
            ]
        );
    }
}
