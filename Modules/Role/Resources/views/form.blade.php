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

                    <form method="POST" action="{{ url('role/store') }}">
                        <input type="hidden" name="id" value="{{ $data->id ?? '' }}">
                        @csrf
                        <div class="">
                            <div class="form-group">
                                <label for="input1">Role Code</label>
                                <input type="text" class="form-control" id="input1" value="{{ $data->role_code ?? '' }}" placeholder="Role code harus unik" name="role_code">
                            </div>
                            <div class="form-group">
                                <label for="input2">Nama Role</label>
                                <input type="text" class="form-control" id="input2" value="{{ $data->name ?? '' }}" name="name" placeholder="Misalnya : Admin, Sales ...">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <a href="{{ route('role.index') }}" class="btn btn-outline-danger">Kembali</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection