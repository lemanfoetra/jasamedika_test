<option value="">Pilih Kelurahan</option>
@foreach($listKec as $kab)
<option value="{{ $kab->kode_kel }}" {{ $kab->kode_kel == $kode_kel ? 'selected' : '' }}>
    {{ $kab->nama }}
</option>
@endforeach