@extends('template.backend')
@section('title', $title ?? '-')

@section('content')
<!-- container opened -->
<div class="container">

    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div>
            <div>
                <h4>{{ $title ?? '-' }}</h4>
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
            <a href="{{ url('user/create') }}" class="btn btn-primary">Tambah User</a>
            @endif
        </div>
    </div>
    <!-- /breadcrumb -->

    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h5>List User</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th style="width: 20px;">#</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(count($datas) > 0)
                                @foreach($datas as $i => $data)
                                <tr>
                                    <td>{{ ($i + 1) }}</td>
                                    <td>{{ $data->name }}</td>
                                    <td>{{ $data->email }}</td>
                                    <td>{{ $data->role->name }}</td>
                                    <td>
                                        @if(permissionUpdate())
                                        <a href="{{ route('user.edit', $data->id) }}" class="btn btn-primary btn-sm">Edit</a>
                                        @endif
                                        @if(permissionDelete())
                                        <a onclick="return confirm('Yakin hapus?')" href="{{ route('user.delete', $data->id)}}" class="btn btn-danger btn-sm">Hapus</a>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                                @else
                                <tr>
                                    <td class="text-center" colspan="6">Tidak ada data.</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                    {{ $datas->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection