@extends('layouts/contentNavbarLayout')

@section('title', 'PENGGUNA')

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

  <form id="form" class="mb-0" action="{{ route('pengguna.store') }}" method="POST">
    @csrf
    <div class="mx-4">
      <div class="row g-3">
        <div class="col-8 mb-3">
          <label for="nama_lengkap" class="form-label">NAMA LENGKAP</label>
          <input type="text" id="nama_lengkap" name="nama_lengkap" class="form-control" placeholder="Juan sebastian, Andre wijaya, dll." autofocus/>
        </div>
        <div class="col-4 mb-3">
          <label for="telepon" class="form-label">TELEPON</label>
          <input type="text" id="telepon" name="telepon" class="form-control" placeholder="0821xxxxxxxx"/>
        </div>
      </div>
      <div class="row g-3">
        <div class="col-4 mb-3">
          <label for="role" class="form-label">ROLE</label>
          <select id="role" name="role" class="form-select">
            <option disabled selected>Pilihan</option>
            <option value="admin">Administrator</option>
            <option value="marketing">Marketing</option>
          </select>
        </div>
        <div class="col-4 mb-3">
          <label for="email" class="form-label">EMAIL</label>
          <input type="text" id="email" name="email" class="form-control" placeholder="juan.sebastian@mail.com"/>
        </div>
        <div class="col-4 mb-3 form-password-toggle">
          <label for="password" class="form-label">Password</label>
          <div class="input-group input-group-merge">
            <input type="password" id="password" class="form-control" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" />
            <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
          </div>
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
