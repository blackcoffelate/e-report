<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Nota;
use App\Models\Quotation;
use Carbon\Carbon;

class Dashboard extends Controller
{
    public function index()
    {
        $users = auth()->user()->nama_lengkap;

        $dataSeries = [];
        $bulanLabels = [];

        $selectedYear = request('tahun') ?? Carbon::now()->year;

        // $tahun = Nota::pluck('tanggal')->map(function ($date) {
        //     return Carbon::parse($date)->format('Y');
        // })->unique();

        $years = Nota::pluck('tahun')->unique();

        if (auth()->user()->roles->map->name[0] === 'marketing') {
            $totalAkumulasi = Nota::where('marketing', $users)
            ->when($selectedYear, function ($query) use ($selectedYear) {
                return $query->where('tahun', '=', $selectedYear);
            })->sum('total');

            $totalPayment = Nota::where('marketing', $users)
            ->when($selectedYear, function ($query) use ($selectedYear) {
                return $query->where('tahun', '=', $selectedYear);
            })->sum('payment');

            $totalPaid = Nota::where('marketing', $users)
            ->when($selectedYear, function ($query) use ($selectedYear) {
                return $query->where('tahun', '=', $selectedYear);
            })->sum('paid');

            $totalAmount = Nota::where('marketing', $users)
            ->when($selectedYear, function ($query) use ($selectedYear) {
                return $query->where('tahun', '=', $selectedYear);
            })->sum('amount');

            $totalQuotation = Quotation::where('marketing', $users)
            ->when($selectedYear, function ($query) use ($selectedYear) {
                return $query->where('tahun', '=', $selectedYear);
            })->sum('amount');

            $query = Nota::select('amount', 'payment', 'paid', 'total', 'bulan', 'marketing as nama_marketing')
            ->where('tahun', $selectedYear);

            $data = $query->get();

            $data = Nota::where('marketing', $users)
                  ->where('tahun', '=', $selectedYear)
                  ->selectRaw('
                    bulan,
                    marketing as nama_marketing,
                    SUM(amount) as total_amount,
                    SUM(payment) as total_payment,
                    SUM(paid) as total_paid,
                    SUM(total) as total_total
                ')
                  ->groupBy('bulan', 'marketing')
                  ->get();

            $dataSeries[] = [
                'nama_marketing' => $this->formatNamaMarketing($users),
                'data' => $data->map(function ($item) {
                    return [
                        'amount' => $item->total_amount,
                        'payment' => $item->total_payment,
                        'paid' => $item->total_paid,
                        'total' => $item->total_total,
                    ];
                })->toArray(),
            ];

            $bulanLabels = $data->pluck('bulan')->unique()->values()->toArray();

            $dataSeriesJson = json_encode($dataSeries);
            $bulanLabelsJson = json_encode($bulanLabels);

            return view('content.dashboard.dashboards', compact('dataSeriesJson', 'bulanLabelsJson', 'years', 'totalAkumulasi', 'totalPayment', 'totalPaid', 'totalAmount', 'totalQuotation', 'selectedYear'));
        } else {
            $totalAkumulasi = Nota::when($selectedYear, function ($query) use ($selectedYear) {
                return $query->where('tahun', '=', $selectedYear);
            })->sum('total');

            $totalPayment = Nota::when($selectedYear, function ($query) use ($selectedYear) {
                return $query->where('tahun', '=', $selectedYear);
            })->sum('payment');

            $totalPaid = Nota::when($selectedYear, function ($query) use ($selectedYear) {
                return $query->where('tahun', '=', $selectedYear);
            })->sum('paid');

            $totalAmount = Nota::when($selectedYear, function ($query) use ($selectedYear) {
                return $query->where('tahun', '=', $selectedYear);
            })->sum('amount');

            $totalQuotation = Quotation::when($selectedYear, function ($query) use ($selectedYear) {
                return $query->where('tahun', '=', $selectedYear);
            })->sum('amount');

            $currentYear = Carbon::now()->year;

            $distinctMarketing = Nota::select('marketing')->distinct()->pluck('marketing')->toArray();

            $dataSeries = [];
            $bulanLabels = [];

            foreach ($distinctMarketing as $marketing) {
                $data = Nota::where('marketing', $marketing)
                  ->where('tahun', '=', $selectedYear)
                  ->selectRaw('
                    bulan,
                    marketing as nama_marketing,
                    SUM(amount) as total_amount,
                    SUM(payment) as total_payment,
                    SUM(paid) as total_paid,
                    SUM(total) as total_total
                ')
                  ->groupBy('bulan', 'marketing')
                  ->get();

                $dataSeries[] = [
                    'nama_marketing' => $this->formatNamaMarketing($marketing),
                    'data' => $data->map(function ($item) {
                        return [
                            'amount' => $item->total_amount,
                            'payment' => $item->total_payment,
                            'paid' => $item->total_paid,
                            'total' => $item->total_total,
                        ];
                    })->toArray(),
                ];

                $bulanLabels = $data->pluck('bulan')->unique()->values()->toArray();
            }

            $dataSeriesJson = json_encode($dataSeries);
            $bulanLabelsJson = json_encode($bulanLabels);

            return view('content.dashboard.dashboards', compact('dataSeriesJson', 'bulanLabelsJson', 'years', 'totalAkumulasi', 'totalPayment', 'totalPaid', 'totalAmount', 'totalQuotation', 'selectedYear'));
        }
    }

    private function formatNamaMarketing($namaMarketing)
    {
        return ucwords(strtolower($namaMarketing));
    }
}
