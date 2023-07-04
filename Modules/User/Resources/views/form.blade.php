@extends('template.backend')
@section('title', $title ?? '-')

@section('content')
<!-- container opened -->
<div class="container">

    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div>
            <div>
                <h4>{{ $title ?? '-'}}</h4>
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
    </div>
    <!-- /breadcrumb -->

    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8">
            @if (session('message') != null)
            <div class="alert alert-success">
                {{ session('message') ?? '' }}
            </div>
            <br>
            @endif
            <div class="card card-primary">
                <div class="card-header">
                    <h5>{{ $title ?? '-'}}</h5>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <form method="POST" action="{{ url('user/store') }}">
                        <input type="hidden" name="id" value="{{ $data->id ?? '' }}">
                        @csrf
                        <div class="">
                            <div class="form-group">
                                <label for="input1">Nama Lengkap</label>
                                <input type="text" class="form-control" id="input1" value="{{ $data->name ?? old('name') }}" name="name">
                            </div>
                            <div class="form-group">
                                <label for="input2">Email</label>
                                <input type="text" class="form-control" id="input2" value="{{ $data->email ?? old('email') }}" name="email">
                            </div>
                            <div class="form-group">
                                <label for="input2">Role</label>
                                <select class="form-control" name="role_code">
                                    <option value="">Pilih Role</option>
                                    @if(count($roles) > 0)
                                    @foreach($roles as $role)
                                    <option value="{{ $role->role_code }}" {{ ($data->role_code ?? '') == $role->role_code ? 'selected' : '' }}>
                                        {{ $role->name }}
                                    </option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="password">Passowrd</label>
                                <input type="password" class="form-control" id="password" name="password">
                            </div>
                            <div class="form-group">
                                <label for="password_confirmation">Konfirmasi Password</label>
                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <a href="{{ route('user.index') }}" class="btn btn-outline-danger">Kembali</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    if ("{{ $data->id ?? '' }}" != '') {
        $("#password").attr("autocomplete", "off");
    }
</script>
@endsection