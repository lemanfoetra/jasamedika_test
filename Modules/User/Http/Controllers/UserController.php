<?php

namespace Modules\User\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Modules\User\Http\Requests\CreateUserRequest;

class UserController extends Controller
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
        return view(
            'user::index',
            [
                'title' => 'User Managment',
                'datas' => User::paginate(15),
                'breadcrumb' => [
                    ['title' => 'Home', 'link' => ''],
                    ['title' => 'User Managment', 'link' => route('user.index')]
                ]
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view(
            'user::form',
            [
                'title'         => 'Tambah User',
                'roles'         => Role::all(),
                'breadcrumb' => [
                    [
                        'title' => 'Home', 'link' => ''
                    ],
                    [
                        'title' => 'User Managment', 'link' => route('user.index'),
                    ],
                    [
                        'title' => 'Tambah User', 'link' => '',
                    ]
                ]
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(CreateUserRequest $request)
    {
        try {
            DB::beginTransaction();
            $data = [
                'role_code' => $request->role_code,
                'name'      => $request->name,
                'email'     => $request->email,
            ];
            if ($request->password != null) {
                $data['password'] = Hash::make($request->password);
            }

            if ($request->id != null) {
                User::where('id', $request->id)->update($data);
            } else {
                User::create($data);
            }
            DB::commit();
            return redirect()->back()->with('message', 'User berhasil disimpan.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('message', 'Error server.');
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('user::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit(User $user)
    {
        return view(
            'user::form',
            [
                'title'         => 'Edit User',
                'roles'         => Role::all(),
                'data'          => $user,
                'breadcrumb' => [
                    [
                        'title' => 'Home', 'link' => ''
                    ],
                    [
                        'title' => 'User Managment', 'link' => route('user.index'),
                    ],
                    [
                        'title' => 'Edit User', 'link' => '',
                    ]
                ]
            ]
        );
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function remove($id)
    {
        User::where('id', $id)->delete();
        return redirect()->back();
    }
}
