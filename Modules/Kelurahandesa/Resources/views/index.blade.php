@extends('template.backend')
@section('title', $title ?? '-')

@section('style')
<link href="{{ url('templates-backend') }}/plugins/datatable2/datatables.min.css" rel="stylesheet" />
@endsection

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
            <a href="{{ url('kelurahandesa/create') }}" class="btn btn-primary">Tambah</a>
            @endif
        </div>
    </div>
    <!-- /breadcrumb -->

    <div class="row">
        @if (session('message_success') != null)
        <div class="col-md-12">
            <div class="alert alert-success">
                {{ session('message_success') ?? '' }}
            </div>
        </div>
        @endif
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="table_list" class="table table-hover">
                            <thead>
                                <tr>
                                    <th style="width: 20px;">#</th>
                                    <th style="width: 200px">Kode Kelurahan/Desa</th>
                                    <th>Provinsi</th>
                                    <th>Kabupaten / Kota</th>
                                    <th>Kecamatan</th>
                                    <th>Kelurahan/Desa</th>
                                    <th class="text-center" style="width: 150px">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
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
<script src="{{ url('templates-backend') }}/plugins/datatable2/datatables.min.js"></script>

<script>
    $(document).ready(function() {
        loadData();
    });

    function loadData() {
        $('#table_list').DataTable().destroy();
        var dataTable = $('#table_list').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                url: `{{ route('kelurahandesa.list_desa') }}`,
                type: "GET",
                error: function() {}
            },
            "fnCreatedRow": function(nRow, aData, iDataIndex) {}
        });
    }
</script>
@endsection