@extends('template.backend')
@section('title', 'Role Management')

@section('content')
<!-- container opened -->
<div class="container">

    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div>
            <div>
                <h4>Role Managment</h4>
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
            <a href="{{ url('role/create') }}" class="btn btn-primary">Tambah Role</a>
        </div>
    </div>
    <!-- /breadcrumb -->

    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h5>List Role</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th style="width: 20px;">#</th>
                                    <th>Role Code</th>
                                    <th>Role Name</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(count($datas) > 0)
                                @foreach($datas as $i => $data)
                                <tr>
                                    <td>{{ ($i + 1)}}</td>
                                    <td>{{ $data->role_code }}</td>
                                    <td>{{ $data->name }}</td>
                                    <td style="width: 250px;" class="text-center">
                                        <a href="{{ url('role/access/'. $data->id) }}" class="btn btn-sm btn-outline-primary">Akses Menu</a>
                                        <a href="{{ url('role/update/'. $data->id) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                        <a onclick="return confirm('Yakin hapus?')" href="{{ url('role/delete/'. $data->id) }}" class="btn btn-sm btn-danger">Delete</a>
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