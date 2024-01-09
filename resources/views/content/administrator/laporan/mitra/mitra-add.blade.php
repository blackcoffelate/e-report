@extends('layouts/contentNavbarLayout')

@section('title', 'KERJSAMA MITRA')

@section('page-script')
<script>
  function goBack() {
    window.history.back();
  }

  $(document).ready(function(){
    $('#success-message').delay(5000).fadeOut(500);

    $('#error-message').delay(5000).fadeOut(500);
  });
</script>
@endsection

@section('page-style')
<style>
input[type="number"]::-webkit-inner-spin-button,
input[type="number"]::-webkit-outer-spin-button {
  -webkit-appearance: none;
  margin: 0;
}

input[type="number"] {
  -moz-appearance: textfield;
}
</style>
@endsection

@section('content')
<div class="navbar-nav-right d-flex align-items-center mb-4">
  <div>
    <button class="btn" style="background-color: #0a6ae7; color: #ffffff;" onclick="goBack()">KEMBALI</button>
  </div>
</div>

@if(session('success'))
<div class="alert alert-success" id="success-message">
    {{ session('success') }}
</div>
@endif

@if($errors->any())
<div class="alert alert-danger" id="error-message">
  @foreach($errors->all() as $error)
    {{ $error }}
  @endforeach
</div>
@endif

<!-- Basic Bootstrap Table -->
<div class="card">
  <div class="card-body navbar-nav-right d-flex">
    <div>
      <h5 class="card-title text-dark fw-bold">FORM INPUT</h5>
    </div>
  </div>

  <form id="form" class="mb-0" action="{{ route('laporan-mitra.store') }}" method="POST">
    @csrf
    <div class="mx-4">
      <div class="row g-3">
        <div class="col-4 mb-3">
          <label for="type" class="form-label">JENIS MITRA</label>
          <select id="type" name="type" class="form-select">
            <option selected disabled>Pilihan</option>
            @foreach($listjenismitra as $data)
            <option value="{{ $data->jenis_mitra }}">{{ $data->jenis_mitra }}</option>
            @endforeach
          </select>
        </div>
        <div class="col-4 mb-3">
          <label for="tanggal" class="form-label">TANGGAL INTERAKSI</label>
          <input type="date" id="tanggal" name="tanggal" class="form-control">
        </div>
        <div class="col-4 mb-3">
          <label for="bulan" class="form-label">BULAN INTERAKSI</label>
          <select id="bulan" name="bulan" class="form-select">
            <option disabled selected>Pilihan</option>
            <option value="jan">Januari</option>
            <option value="feb">Februari</option>
            <option value="mar">Maret</option>
            <option value="apr">April</option>
            <option value="mei">Mei</option>
            <option value="jun">Juni</option>
            <option value="jul">Juli</option>
            <option value="aug">Agustus</option>
            <option value="sep">September</option>
            <option value="oct">Oktober</option>
            <option value="nov">November</option>
            <option value="dec">Desember</option>
          </select>
        </div>
      </div>
      <div class="row g-3">
        <div class="col-4 mb-3">
          <label for="tahun" class="form-label">TAHUN INTERAKSI</label>
          <input type="text" id="tahun" name="tahun" class="form-control" placeholder="Masukan tahun nota">
        </div>
        <div class="col-4 mb-3">
          <label for="mitra" class="form-label">NAMA MITRA</label>
          <input type="text" id="mitra" name="mitra" class="form-control" placeholder="Masukan nama mitra">
        </div>
        <div class="col-4 mb-3">
          <label for="telepon" class="form-label">TELEPON MITRA</label>
          <input type="text" id="telepon" name="telepon" class="form-control" placeholder="Masukan telepon mitra">
        </div>
      </div>
      <div class="row g-3">
        <div class="col mb-3">
          <label for="alamat" class="form-label">ALAMAT</label>
          <input type="text" id="alamat" name="alamat" class="form-control" placeholder="Masukan alamat mitra">
        </div>
      </div>
    </div>
    <div class="card-footer">
      <button type="submit" id="savedata" class="btn btn-dark">SIMPAN DATA</button>
    </div>
  </form>

</div>
<!--/ Basic Bootstrap Table -->
@endsection
