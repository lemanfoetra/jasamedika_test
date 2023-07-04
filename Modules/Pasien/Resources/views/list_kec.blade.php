<option value="">Pilih Kecamatan</option>
@foreach($listKec as $kab)
<option value="{{ $kab->kode_kec }}" {{ $kab->kode_kec == $kode_kec ? 'selected' : '' }}>
    {{ $kab->nama }}
</option>
@endforeach