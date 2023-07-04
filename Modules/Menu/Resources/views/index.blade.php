@extends('template.backend')
@section('title', 'Menu Management')

@section('content')
<!-- container opened -->
<div class="container">

    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div>
            <div>
                <h4>Menu Managment</h4>
            </div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-style1">
                    @if(isset($breadcrumb))
                    @foreach($breadcrumb as $i => $br)
                    @if(($i + 1) == count($breadcrumb))
                    <li class="breadcrumb-item active">{{ $br['title'] ?? '-' }}</li>
                    @else
                    <li class="breadcrumb-item">
                        <a href="{{ $br['link'] ?? '#' }}">{{ $br['title'] ?? '-' }}</a>
                    </li>
                    @endif
                    @endforeach
                    @endif
                </ol>
            </nav>
        </div>
        <div class="" style="padding-top: 10px; text-align: right">
            @if(permissionCreate())
            <a href="{{ url('menu/create') }}" class="btn btn-primary">Tambah Menu</a>
            @endif
        </div>
    </div>
    <!-- /breadcrumb -->

    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h5>List Menu</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered">
                            <thead>
                                <tr>
                                    <th style="width: 20px;">#</th>
                                    <th>Menu Name</th>
                                    <th>Link</th>
                                    <th>Urutan</th>
                                    <th class="text-center" style="width: 150px;" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(count($menus) > 0)
                                @foreach($menus as $i => $menu)
                                <tr>
                                    <td>{{ ($i + 1) }}</td>
                                    <td><?= $menu['menu'] ?? '-' ?></td>
                                    <td>{{ $menu['link'] ?? '-' }}</td>
                                    <td>{{ $menu['urutan'] }}</td>
                                    <td class="text-center">
                                        @if(permissionUpdate())
                                        <a href="{{ route('menu.edit', $menu['id']) }}" class="btn btn-sm btn-primary">Edit</a>
                                        @endif
                                        @if(permissionDelete())
                                        <a href="{{ route('menu.delete', $menu['id']) }}" onclick="return confirm('Yakin hapus?')" class="btn btn-sm btn-danger">Hapus</a>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection