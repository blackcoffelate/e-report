@extends('layouts/contentNavbarLayout')

@section('title', 'DASHBOARD')

@section('vendor-style')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/apex-charts/apex-charts.css')}}">
@endsection

@section('vendor-script')
<script src="{{asset('assets/vendor/libs/apex-charts/apexcharts.js')}}"></script>
@endsection

@section('page-script')
<script src="{{asset('assets/js/dashboards-analytics.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<script>
@if(auth()->user()->roles->map->name[0] === 'marketing')
document.addEventListener("DOMContentLoaded", function() {
  var dataSeries = {!! $dataSeriesJson !!};
  var bulanLabels = {!! $bulanLabelsJson !!};
  var seriesData = [];

  dataSeries.forEach(function(series) {
    seriesData.push({
      name: '',
      data: series.data.map(function (item) {
        return item.total;
      })
    });
  });

  var options = {
    chart: {
      type: 'line',
    },
    series: seriesData,
    xaxis: {
      categories: bulanLabels,
      responsive: true,
    },
    tooltip: {
      y: {
        formatter: function (val, opts) {
          var data = dataSeries[opts.seriesIndex].data[opts.dataPointIndex];
          var namaMarketing = dataSeries[opts.seriesIndex].nama_marketing;

          var formattedAmount = new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
          }).format(data.amount);

          var formattedPayment = new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
          }).format(data.payment);

          var formattedPaid = new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
          }).format(data.paid);

          var formattedTotal = new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
          }).format(val);

          var tooltipText = `
          <strong>${namaMarketing}</strong><br>
          Amount: ${formattedAmount}<br>
          Payment: ${formattedPayment}<br>
          Paid: ${formattedPaid}<br>
          Total: ${formattedTotal}`;

          return tooltipText;
        },
      },
    },
  };

  var chart = new ApexCharts(document.querySelector("#chart"), options);
  chart.render();
});
@else
document.addEventListener("DOMContentLoaded", function() {
  var dataSeries = {!! $dataSeriesJson !!};
  var bulanLabels = {!! $bulanLabelsJson !!};
  var seriesData = [];

  dataSeries.forEach(function(series) {
    seriesData.push({
      name: '',
      data: series.data.map(function (item) {
        return item.total;
      })
    });
  });

  var options = {
    chart: {
      type: 'line',
    },
    series: seriesData,
    xaxis: {
      categories: bulanLabels,
      responsive: true,
    },
    tooltip: {
      y: {
        formatter: function (val, opts) {
          var data = dataSeries[opts.seriesIndex].data[opts.dataPointIndex];
          var namaMarketing = dataSeries[opts.seriesIndex].nama_marketing;

          var formattedAmount = new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
          }).format(data.amount);

          var formattedPayment = new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
          }).format(data.payment);

          var formattedPaid = new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
          }).format(data.paid);

          var formattedTotal = new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
          }).format(val);

          var tooltipText = `
          <strong>${namaMarketing}</strong><br>
          Amount: ${formattedAmount}<br>
          Payment: ${formattedPayment}<br>
          Paid: ${formattedPaid}<br>
          Total: ${formattedTotal}`;

          return tooltipText;
        },
      },
    },
  };

  var chart = new ApexCharts(document.querySelector("#chart"), options);
  chart.render();
});
@endif
</script>
@endsection

@section('content')
<div class="row">
  <div class="navbar-nav-right d-flex align-items-center">
    <div class="ms-auto">
      <form id="form" class="mb-0" action="{{ route('dashboard') }}" method="GET">
        @csrf
        <div class="row g-3 d-flex align-items-center">
          <div class="col mb-4">
            <label for="tahun" class="form-label">Pilihan tahun</label>
            <select id="tahun" name="tahun" class="form-select" style="width: 245px">
              <option disabled selected>Pilihan</option>
              @foreach ($years as $tahunOption)
                <option value="{{ $tahunOption }}">{{ $tahunOption }}</option>
              @endforeach
            </select>
          </div>
          <div class="col">
            <button type="submit" class="btn" style="background-color: #0a6ae7; color: #ffffff;">FILTER</button>
          </div>
        </div>
      </form>
    </div>
  </div>
  <div class="col-lg-8 mb-4 order-0">
    <div class="card">
      <div class="row row-bordered g-0">
        <div class="col-md-12">
          <h5 class="card-header m-0 me-2 pb-3">MARKETING &nbsp;&nbsp;<small class="badge bg-dark">@auth {{auth()->user()->nama_lengkap}} @endauth</small></h5>
          <div id="chart" style="width: 97%"></div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-lg-4 col-md-4 order-1">
    <div class="row">
      <div class="col-lg-6 col-md-12 col-6 mb-4">
        <div class="card">
          <div class="card-body">
            <div class="card-title d-flex align-items-start justify-content-between">
              <div class="avatar flex-shrink-0">
                <img src="{{asset('assets/img/icons/unicons/chart-success.png')}}" alt="chart success" class="rounded">
              </div>
            </div>
            <span class="fw-semibold d-block mb-1">Amount</span>
            <small class="card-title mb-2">{{ 'Rp. '.number_format($totalAmount, 0, ',', '.'); }}</small>
          </div>
        </div>
      </div>
      <div class="col-lg-6 col-md-12 col-6 mb-4">
        <div class="card">
          <div class="card-body">
            <div class="card-title d-flex align-items-start justify-content-between">
              <div class="avatar flex-shrink-0">
                <img src="{{asset('assets/img/icons/unicons/chart-success.png')}}" alt="Credit Card" class="rounded">
              </div>
            </div>
            <span class="fw-semibold d-block mb-1">Payment</span>
            <small class="card-title mb-2">{{ 'Rp. '.number_format($totalPayment, 0, ',', '.'); }}</small>
          </div>
        </div>
      </div>

      <div class="col-6 mb-4">
        <div class="card">
          <div class="card-body">
            <div class="card-title d-flex align-items-start justify-content-between">
              <div class="avatar flex-shrink-0">
                <img src="{{asset('assets/img/icons/unicons/chart-success.png')}}" alt="Credit Card" class="rounded">
              </div>
            </div>
            <span class="fw-semibold d-block mb-1">Paid</span>
            <small class="card-title mb-2">{{ 'Rp. '.number_format($totalPaid, 0, ',', '.'); }}</small>
          </div>
        </div>
      </div>
      <div class="col-6 mb-4">
        <div class="card">
          <div class="card-body">
            <div class="card-title d-flex align-items-start justify-content-between">
              <div class="avatar flex-shrink-0">
                <img src="{{asset('assets/img/icons/unicons/chart-success.png')}}" alt="Credit Card" class="rounded">
              </div>
            </div>
            <span class="fw-semibold d-block mb-1">Quotation</span>
            <small class="card-title mb-2">{{ 'Rp. '.number_format($totalQuotation, 0, ',', '.'); }}</small>
          </div>
        </div>
      </div>

      <div class="col-12 mb-4">
        <div class="card">
          <div class="card-body">
            <div class="d-flex justify-content-between flex-sm-row flex-column gap-3">
              <div class="d-flex flex-sm-column flex-row align-items-start justify-content-between">
                <div class="card-title">
                  <h5 class="text-nowrap mb-2">Total payment paid</h5>
                  <span class="badge bg-label-warning rounded-pill">Tahun {{ $selectedYear }}</span>
                </div>
                <div class="mt-sm-auto">
                  <small class="mb-0">{{ 'Rp. '.number_format($totalAkumulasi, 0, ',', '.'); }}</small>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
