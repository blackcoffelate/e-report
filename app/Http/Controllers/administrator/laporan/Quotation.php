<?php

namespace App\Http\Controllers\administrator\laporan;

use App\DataTables\QuotationDataTable;
use App\Http\Controllers\Controller;
use App\Models\Quotation as ModelsQuotation;
use Illuminate\Http\Request;

class Quotation extends Controller
{
    public function index(QuotationDataTable $datatable)
    {
        $month = request('bulan');
        $year = request('tahun');

        $users = auth()->user()->nama_lengkap;

        $tahun = ModelsQuotation::distinct()->pluck('tahun');

        if (auth()->user()->roles->map->name[0] === 'marketing') {
            $totalAkumulasi = ModelsQuotation::where('marketing', $users)
                ->when(isset($month) && isset($year), function ($query) use ($month, $year) {
                    return $query->where('bulan', $month)->where('tahun', $year);
                })->sum('amount');
        } else {
            $totalAkumulasi = ModelsQuotation::when(isset($month) && isset($year), function ($query) use ($month, $year) {
                return $query->where('bulan', $month)->where('tahun', $year);
            })->sum('amount');
        }

        return $datatable->with(compact('month', 'year'))->render('content.administrator.laporan.quotation.quotation', compact('totalAkumulasi', 'tahun'));
    }

    public function add()
    {
        return view('content.administrator.laporan.quotation.quotation-add');
    }

    public function update($id)
    {
        $data = ModelsQuotation::get()->find($id);

        return view('content.administrator.laporan.quotation.quotation-update', compact('data'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
          'file' => 'required|mimes:jpg,jpeg,png,gif,xls,xlsx,pdf|max:2048',
          'nomor' => 'required',
          'tanggal' => 'required',
          'bulan' => 'required',
          'tahun' => 'required',
          'customer' => 'required',
          'telepon' => 'required',
          'amount' => 'required',
          'street' => 'required',
          'district' => 'required',
          'city' => 'required',
        ]);

        $type = 'quotation';
        $marketing = auth()->user()->nama_lengkap;
        $amountin = $request['amount'];

        $file = $request->file('file');
        $timestamp = now()->format('dmY');
        $fileName = 'quotation_'.$timestamp.'_'.$file->getClientOriginalName();
        $file->storeAs('public/quotation', $fileName);

        $data = [
          'file' => $fileName, 'type' => $type, 'nomor' => $request['nomor'], 'marketing' => $marketing,
          'tanggal' => $request['tanggal'], 'bulan' => $request['bulan'], 'tahun' => $request['tahun'],
          'customer' => $request['customer'], 'telepon' => $request['telepon'],
          'amount' => $amountin, 'street' => $request['street'],
          'district' => $request['district'], 'city' => $request['city'],
        ];

        ModelsQuotation::updateOrCreate(
            ['id' => $request->id],
            $data
        );

        return redirect()->route('laporan-quotation.add')->with('success', 'Data quotation berhasil ditambahkan.');
    }

    public function put(Request $request, $id)
    {
        $this->validate($request, [
          'file' => 'required|mimes:jpg,jpeg,png,gif,xls,xlsx,pdf|max:2048',
          'nomor' => 'required',
          'tanggal' => 'required',
          'bulan' => 'required',
          'tahun' => 'required',
          'customer' => 'required',
          'telepon' => 'required',
          'amount' => 'required',
          'street' => 'required',
          'district' => 'required',
          'city' => 'required',
        ]);

        $type = 'quotation';
        $marketing = auth()->user()->nama_lengkap;
        $amountin = $request['amount'];

        $file = $request->file('file');
        $timestamp = now()->format('dmY');
        $fileName = 'quotation_'.$timestamp.'_'.$file->getClientOriginalName();
        $file->storeAs('public/quotation', $fileName);

        $data = [
          'file' => $fileName, 'type' => $type, 'nomor' => $request['nomor'], 'marketing' => $marketing,
          'tanggal' => $request['tanggal'], 'bulan' => $request['bulan'], 'tahun' => $request['tahun'],
          'customer' => $request['customer'], 'telepon' => $request['telepon'],
          'amount' => $amountin, 'street' => $request['street'],
          'district' => $request['district'], 'city' => $request['city'],
        ];

        ModelsQuotation::where('id', $id)->update($data);

        return redirect()->route('laporan-quotation')->with('success', 'Data quotation berhasil diubah.');
    }

    public function delete($id)
    {
        ModelsQuotation::find($id)->delete($id);

        return response()->json(['success' => 'Record deleted successfully!']);
    }

    public function download($fileName)
    {
        $filePath = str_replace('/', '\\', storage_path('app/public/quotation/'.$fileName));

        return response()->download($filePath);
    }
}
