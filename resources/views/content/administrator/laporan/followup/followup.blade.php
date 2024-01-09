@extends('layouts/contentNavbarLayout')

@section('title', 'FOLLOW UP')

@section('page-script')
<script src="{{asset('assets/vendor/libs/masonry/masonry.js')}}"></script>
{{ $dataTable->scripts() }}

<script>
  $(function() {
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

    $('#followup-table').on('click', '.delete', function() {
      let token = $("meta[name='csrf-token']").attr("content");
      var id = $(this).data('id');
      $('#formDelete').modal('show');
      $('#delete-post').click(function(e) {
        $.ajax({
            url: "/laporan/followup/delete/" + id,
            type: 'DELETE',
            data: {
              "id": id,
              "_token": token,
            },
            success: function() {
              window.location.reload();
            }
          })
        })
    });

    $('#followup-table').on('click', '.update', function() {
      var id = $(this).data('id');
      window.location.href = '/laporan/followup/update/'+id;
    });

    $('#reload').click(function() {
      location.reload();
    });

  });
</script>
@endsection

@section('content')
<div class="navbar-nav-right d-flex align-items-center">
  <div class="demo-inline-spacing pb-1 mb-4">
    <a href="{{ route('laporan-followup.add') }}" type="button" class="btn" style="background-color: #0a6ae7; color: #ffffff;">DATA BARU</a>
    <button type="button" class="btn btn-icon" id="reload" style="background-color: #0a6ae7; color: #ffffff;"><span class='tf-icons bx bx-refresh'></span></button>
  </div>
  <div class="ms-auto">
    @can('isAdmin')
    <form id="form" class="mb-0" action="{{ route('laporan-followup') }}" method="GET">
      @csrf
      <div class="row g-3 d-flex align-items-center">
        <div class="col mb-4">
          <label for="bulan" class="form-label">Pilihan bulan</label>
          <select id="bulan" name="bulan" class="form-select" style="width: 200px">
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
        <div class="col mb-4">
          <label for="tahun" class="form-label">Pilihan tahun</label>
          <select id="tahun" name="tahun" class="form-select" style="width: 200px">
            <option disabled selected>Pilihan</option>
            @foreach ($tahun as $tahunOption)
              <option value="{{ $tahunOption }}">{{ $tahunOption }}</option>
            @endforeach
          </select>
        </div>
        <div class="col">
          <button type="submit" class="btn" style="background-color: #0a6ae7; color: #ffffff;">FILTER</button>
        </div>
      </div>
    </form>
    @else
    <form id="form" class="mb-0" action="{{ route('laporan-followup') }}" method="GET">
      @csrf
      <div class="row g-3 d-flex align-items-center">
        <div class="col mb-4">
          <label for="bulan" class="form-label">Pilihan bulan</label>
          <select id="bulan" name="bulan" class="form-select" style="width: 200px">
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
        <div class="col mb-4">
          <label for="tahun" class="form-label">Pilihan tahun</label>
          <select id="tahun" name="tahun" class="form-select" style="width: 200px">
            <option disabled selected>Pilihan</option>
            @foreach ($tahun as $tahunOption)
              <option value="{{ $tahunOption }}">{{ $tahunOption }}</option>
            @endforeach
          </select>
        </div>
        <div class="col">
          <button type="submit" class="btn" style="background-color: #0a6ae7; color: #ffffff;">FILTER</button>
        </div>
      </div>
    </form>
    @endcan
  </div>
</div>

<!-- Text alignment -->
<div class="row mb-5">
  <div class="col-md-6 col-lg-12">
    <div class="card mb-3">
      <div class="card-body">
        <h5 class="card-title">FOLLOW UP &nbsp;&nbsp;<small class="badge bg-dark">@auth {{auth()->user()->nama_lengkap}} @endauth</small></h5>
        <p class="text-muted">Kumpulan seluruh data follow up yang telah di daftarkan ke dalam sistem.</p>
      </div>
      <div class="card-body">
        {{ $dataTable->table() }}
      </div>
    </div>
  </div>
</div>
<!--/ Text alignment -->
@csrf
@include('_partials.modal-delete')
@endsection
