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

                    <form method="POST" action="{{ url('menu/store') }}">
                        <input type="hidden" name="id" value="{{ $data->id ?? '' }}">
                        @csrf
                        <div class="">
                            <div class="form-group">
                                <label for="input1">Parrent Menu</label>
                                <select class="form-control select2" name="parrent_menu_id" required>
                                    <option value="0">Posisi Utama</option>
                                    <?= ($menus ?? '') ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="input2">Nama Menu</label>
                                <input type="text" class="form-control" id="input2" value="{{ $data->name ?? '' }}" name="name" required>
                            </div>
                            <div class="form-group">
                                <label for="input3">Link Menu</label>
                                <input type="text" class="form-control" id="input3" value="{{ $data->link ?? '' }}" name="link">
                            </div>
                            <div class="form-group">
                                <label for="input4">Urutan Menu</label>
                                <input type="number" min="0" class="form-control" id="input4" value="{{ $data->urutan ?? '' }}" name="urutan" required>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <a href="{{ route('menu.index') }}" class="btn btn-outline-danger">Kembali</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    
</script>
@endsection