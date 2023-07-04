<option value="">Pilih Kabupaten / Kota</option>
@foreach($listKab as $kab)
<option value="{{ $kab->kode_kab }}" {{ $kab->kode_kab == $kode_kab ? 'selected' : '' }}>
    {{ $kab->nama }}
</option>
@endforeach