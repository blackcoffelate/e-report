@extends('layouts/contentNavbarLayout')

@section('title', 'JENIS MITRA')

@section('page-script')
<script src="{{asset('assets/vendor/libs/masonry/masonry.js')}}"></script>
{{ $dataTable->scripts() }}

<script>
  $(function() {
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

    $('#jenismitra-table').on('click', '.delete', function() {
      let token = $("meta[name='csrf-token']").attr("content");
      var id = $(this).data('id');
      $('#formDelete').modal('show');
      $('#delete-post').click(function(e) {
        $.ajax({
            url: "/jenis-mitra/delete/" + id,
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

    $('#jenismitra-table').on('click', '.update', function() {
      var id = $(this).data('id');
      window.location.href = 'jenis-mitra/update/'+id;
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
    <a href="{{ route('jenis-mitra.add') }}" type="button" class="btn" style="background-color: #0a6ae7; color: #ffffff;">DATA BARU</a>
    <button type="button" class="btn btn-icon" id="reload" style="background-color: #0a6ae7; color: #ffffff;"><span class='tf-icons bx bx-refresh'></span></button>
  </div>
</div>

<!-- Text alignment -->
<div class="row mb-5">
  <div class="col-md-6 col-lg-12">
    <div class="card mb-3">
      <div class="card-body">
        <h5 class="card-title">JENIS MITRA</h5>
        <p class="text-muted">Kumpulan seluruh jenis mitra yang telah di daftarkan ke dalam sistem.</p>
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
