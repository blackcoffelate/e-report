@extends('layouts/contentNavbarLayout')

@section('title', 'JENIS MITRA')

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
      <h5 class="card-title text-dark fw-bold">FORM UPDATE</h5>
    </div>
  </div>

  <form id="form" class="mb-0" action="{{ route('jenis-mitra.put', $data->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="mx-4">
      <div class="row g-3">
        <div class="col-6 mb-3">
          <label for="jenis_mitra" class="form-label">JENIS MITRA</label>
          <input type="text" value="{{$data->jenis_mitra}}" id="jenis_mitra" name="jenis_mitra" class="form-control" placeholder="Arsitek, Desain interior, dll." autofocus/>
        </div>
      </div>
      <div class="row g-3">
        <div class="col mb-3">
          <label for="keterangan" class="form-label">KETERANGAN</label>
          <textarea rows="10" cols="100" id="keterangan" name="keterangan" class="form-control" placeholder="Berikan keterangan mengenai data masukan." value="{{$data->keterangan}}">{{$data->keterangan}}</textarea>
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
