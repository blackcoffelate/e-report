@extends('layouts/contentNavbarLayout')

@section('title', 'QUOTATION')

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

  <form id="form" class="mb-0" action="{{ route('laporan-quotation.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="mx-4">
      <div class="row g-3">
        <div class="col-4 mb-3">
          <label for="file" class="form-label">FILE QUOTATION</label>
          <input type="file" accept=".jpg, .jpeg, .png, .gif, .xls, .xlsx, .pdf" id="file" name="file" class="form-control" placeholder="Ex: 20648">
        </div>
        <div class="col-8 mb-3">
          <label for="nomor" class="form-label">NOMOR QUOTATION</label>
          <input type="text" id="nomor" name="nomor" class="form-control" placeholder="Masukan nomor quotation" autofocus>
        </div>
      </div>
      <div class="row g-3">
        <div class="col-4 mb-3">
          <label for="tanggal" class="form-label">TANGGAL QUOTATION</label>
          <input type="date" id="tanggal" name="tanggal" class="form-control">
        </div>
        <div class="col-4 mb-3">
          <label for="bulan" class="form-label">BULAN QUOTATION</label>
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
        <div class="col-4 mb-3">
          <label for="tahun" class="form-label">TAHUN QUOTATION</label>
          <input type="text" id="tahun" name="tahun" class="form-control" placeholder="Masukan tahun quotation">
        </div>
      </div>
      <div class="row g-3">
        <div class="col-4 mb-3">
          <label for="customer" class="form-label">NAMA CUSTOMER</label>
          <input type="text" id="customer" name="customer" class="form-control" placeholder="Masukan nama customer">
        </div>
        <div class="col-4 mb-3">
          <label for="telepon" class="form-label">TELEPON CUSTOMER</label>
          <input type="text" id="telepon" name="telepon" class="form-control" placeholder="Masukan telepon customer">
        </div>
      </div>
      <div class="row g-3">
        <div class="col-4 mb-3">
          <label for="amount" class="form-label">AMOUNT</label>
          <input type="text" id="amount" name="amount" class="form-control" placeholder="0000000000">
        </div>
      </div>
      <div class="row g-3">
        <div class="col-4 mb-3">
          <label for="street" class="form-label">JALAN</label>
          <input type="text" id="street" name="street" class="form-control" placeholder="Masukan nama jalan">
        </div>
        <div class="col-4 mb-3">
          <label for="district" class="form-label">KECAMATAN</label>
          <input type="text" id="district" name="district" class="form-control" placeholder="Masukan nama kecamatan">
        </div>
        <div class="col-4 mb-3">
          <label for="city" class="form-label">KABUPATEN / KOTA</label>
          <input type="text" id="city" name="city" class="form-control" placeholder="Masukan nama kabupaten / kota">
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
