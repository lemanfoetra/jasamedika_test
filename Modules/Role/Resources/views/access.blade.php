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
                    <div style="margin-bottom: 30px;">
                        <div class="card">
                            <div class="card-body">
                                <table style="width: 100%;">
                                    <tr>
                                        <td style="width: 100px;">Kode Role</td>
                                        <td style="width: 20px;">:</td>
                                        <td>{{ $role->role_code }}</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 200px;">Nama Role</td>
                                        <td style="width: 20px;">:</td>
                                        <td>{{ $role->name }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th colspan="2">Akses Menu</th>
                                    <th>Create</th>
                                    <th>Update</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(count($menus) > 0)
                                @foreach($menus as $i => $data)
                                <tr>
                                    <td style="width: 30px;">
                                        <input type="checkbox" id="menu{{ $data['id'] }}" onclick="setMenu(`{{$data['id']}}`, this)" {{ !empty($data['access_id']) ? 'checked' : '' }}>
                                    </td>
                                    <td><?php echo  $data['menu'] ?></td>
                                    <td><input type="checkbox" {{ $data['create'] == 'Y' ? 'checked' : '' }} id="c{{ $data['id'] }}" onclick="setCreate(`{{$data['id']}}`, this)"></td>
                                    <td><input type="checkbox" {{ $data['update'] == 'Y' ? 'checked' : '' }} id="u{{ $data['id'] }}" onclick="setUpdate(`{{$data['id']}}`, this)"></td>
                                    <td><input type="checkbox" {{ $data['delete'] == 'Y' ? 'checked' : '' }} id="d{{ $data['id'] }}" onclick="setDelete(`{{$data['id']}}`, this)"></td>
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

@section('script')
<script>
    function setMenu(menu_id, element) {
        setAccess(menu_id, '{{ $role->role_code }}', element.checked, 'menu');
    }

    function setCreate(menu_id, element) {
        setAccess(menu_id, '{{ $role->role_code }}', element.checked, 'create');
    }

    function setUpdate(menu_id, element) {
        setAccess(menu_id, '{{ $role->role_code }}', element.checked, 'update');
    }

    function setDelete(menu_id, element) {
        setAccess(menu_id, '{{ $role->role_code }}', element.checked, 'delete');
    }

    function setAccess(menu_id, role_code, checked, flag) {
        $.ajax({
            type: 'GET',
            url: "{{ route('role.set-access') }}",
            data: {
                'menu_id': menu_id,
                'role_code': role_code,
                'flag': flag,
                'checked': checked,
            },
            success: function(data) {

            },
            error: function(data) {
                alert('bermasalah saat memproses data');
            }
        });
    }
</script>
@endsection