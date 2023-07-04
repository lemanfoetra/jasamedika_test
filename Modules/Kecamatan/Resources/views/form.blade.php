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
            @if (session('message_success') != null)
            <div class="alert alert-success">
                {{ session('message_success') ?? '' }}
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

                    <form method="POST" action="{{ url('kecamatan/store') }}">
                        <input type="hidden" name="wilayah_id" value="{{ $data->wilayah_id ?? '' }}">
                        @csrf
                        <div class="">
                            <div class="form-group">
                                <label for="input1">Provinsi *</label>
                                <select class="form-control" name="kode_pro" onchange="list_kab(this.value)" required>
                                    <option value="">Pilih Provinsi</option>
                                    @foreach($provinsies as $prov)
                                    <option value="{{ $prov->kode_pro }}" {{ $prov->kode_pro == ($data->kode_pro ?? '') ? 'selected' : '' }}>
                                        {{ $prov->nama }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="input1">Kabupaten / Kota *</label>
                                <select class="form-control" id="selectbox_list_kab" name="kode_kab" required>
                                    <option value="">Pilih Kabupaten / Kota</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="kode_kec">Kode Wilayah *</label>
                                <input type="number" min="0" class="form-control" id="kode_kec" value="{{ $data->kode_kec ?? old('kode_kec') }}" name="kode_kec" required>
                            </div>
                            <div class="form-group">
                                <label for="input2">Nama Kecamatan *</label>
                                <input type="text" class="form-control" id="input2" value="{{ $data->nama ?? old('nama') }}" name="nama" required>
                            </div>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <a href="{{ route('kecamatan.index') }}" class="btn btn-outline-danger">Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    if ('<?php echo $data->kode_kab ?? '' ?>' != '') {
        list_kab('<?php echo $data->kode_pro ?? '' ?>', '<?php echo $data->kode_kab ?? '' ?>');
    }

    function list_kab(kode_pro, kode_kab = '') {
        $.ajax({
            type: 'GET',
            url: "{{ route('kecamatan.list_kab') }}",
            data: {
                'kode_pro': kode_pro,
                'kode_kab': kode_kab,
            },
            success: function(data) {
                $('#selectbox_list_kab').html(data);
            },
            error: function(data) {
                alert('bermasalah saat memproses data');
            }
        });
    }
</script>
@endsection