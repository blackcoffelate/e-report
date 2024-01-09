@extends('layouts/contentNavbarLayout')

@section('title', 'NOTA')

@section('page-script')
<script src="{{asset('assets/vendor/libs/masonry/masonry.js')}}"></script>
{{ $dataTable->scripts() }}

<script>
  $(function() {
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

    $('#nota-table').on('click', '.delete', function() {
      let token = $("meta[name='csrf-token']").attr("content");
      var id = $(this).data('id');
      $('#formDelete').modal('show');
      $('#delete-post').click(function(e) {
        $.ajax({
            url: "/laporan/nota/delete/" + id,
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

    $('#nota-table').on('click', '.update', function() {
      var id = $(this).data('id');
      window.location.href = '/laporan/nota/update/'+id;
    });

    $('#nota-table').on('click', '.download', function () {
      var fileName = $(this).data('file');
      var downloadUrl = "{{ route('laporan-nota.download', ['fileName' => ':fileName']) }}".replace(':fileName', fileName);
      window.location.href = downloadUrl;
    });

    $('#nota-table').on('click', '.show', function() {
      var id = $(this).data('id');
      console.log(id)
      $.get("{{ url('/laporan/nota/') }}" + '/getById/' + id, function(data) {
        var imageUrl = data.file ? '{{ asset("storage/nota") }}' + "/" + data.file : '{{ asset("assets/img/icons/decoration.png") }}';

        $('#fileImage').attr('src', imageUrl);
        $('#formShow').modal('show');
      })
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
    <a href="{{ route('laporan-nota.add') }}" type="button" class="btn" style="background-color: #0a6ae7; color: #ffffff;">DATA BARU</a>
    <button type="button" class="btn btn-icon" id="reload" style="background-color: #0a6ae7; color: #ffffff;"><span class='tf-icons bx bx-refresh'></span></button>
  </div>
  <div class="ms-auto">
    @can('isAdmin')
    <form id="form" class="mb-0" action="{{ route('laporan-nota') }}" method="GET">
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
    <form id="form" class="mb-0" action="{{ route('laporan-nota') }}" method="GET">
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
        <h5 class="card-title">NOTA &nbsp;&nbsp;<small class="badge bg-dark">@auth {{auth()->user()->nama_lengkap}} @endauth</small>&nbsp;&nbsp;<small class="badge bg-warning">{{ 'Rp. '.number_format($totalAkumulasi, 0, ',', '.'); }}</small></h5>
        <p class="text-muted">Kumpulan seluruh data nota yang telah di daftarkan ke dalam sistem.</p>
      </div>
      <div class="card-body">
        <table id="nota-table" class="table">
          <thead>
              <!-- ... baris head lainnya -->
          </thead>
          <tbody>
              <!-- ... baris data lainnya -->
          </tbody>
          <tfoot>
            <tr>
              <th></th>
              <th></th>
              <th class="fw-bold">GRAND TOTAL</th>
              <th class="fw-bold">{{ 'Rp. '.number_format($amountAkumulasi, 0, ',', '.'); }}</th>
              <th class="fw-bold">{{ 'Rp. '.number_format($paymentAkumulasi, 0, ',', '.'); }}</th>
              <th class="fw-bold">{{ 'Rp. '.number_format($paidAkumulasi, 0, ',', '.'); }}</th>
              <th class="fw-bold">{{ 'Rp. '.number_format($totalAkumulasi, 0, ',', '.'); }}</th>
              <th></th>
            </tr>
          </tfoot>
        </table>
      </div>
    </div>
  </div>
</div>
<!--/ Text alignment -->
@csrf
@include('_partials.modal-delete')
@include('_partials.notify-show')
@endsection
