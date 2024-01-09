<?php

namespace App\Http\Controllers\administrator\laporan;

use App\DataTables\NotaDataTable;
use App\Http\Controllers\Controller;
use App\Models\Nota as ModelsNota;
use Illuminate\Http\Request;

class Nota extends Controller
{
    public function index(NotaDataTable $datatable)
    {
        $month = request('bulan');
        $year = request('tahun');

        $users = auth()->user();
        $role = $users->roles->map->name[0];

        $tahun = ModelsNota::distinct()->pluck('tahun');

        $dataQuery = ModelsNota::when($month && $year, function ($query) use ($month, $year) {
            return $query->where('bulan', $month)->where('tahun', $year);
        });

        if ($role === 'marketing') {
            $dataQuery->where('marketing', $users->nama_lengkap);
        }

        $data = $dataQuery->get()->toArray();

        $totalAkumulasi = collect($data)->sum('total');
        $amountAkumulasi = collect($data)->sum('amount');
        $paymentAkumulasi = collect($data)->sum('payment');
        $paidAkumulasi = collect($data)->sum('paid');

        return $datatable->with(compact('month', 'year'))->render('content.administrator.laporan.nota.nota', compact('totalAkumulasi', 'amountAkumulasi', 'paymentAkumulasi', 'paidAkumulasi', 'tahun'));
    }

    public function add()
    {
        return view('content.administrator.laporan.nota.nota-add');
    }

    public function getById($id)
    {
        $data = ModelsNota::find($id);

        return response()->json($data);
    }

    public function update($id)
    {
        $data = ModelsNota::get()->find($id);

        return view('content.administrator.laporan.nota.nota-update', compact('data'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
          'file' => 'mimes:jpg,jpeg,png,gif|max:2048',
          'nomor' => 'required',
          'tanggal' => 'required',
          'bulan' => 'required',
          'tahun' => 'required',
          'amount' => 'required',
          'payment' => 'required',
          'paid' => 'required',
          'customer' => 'required',
          'telepon' => 'required',
          'street' => 'required',
          'district' => 'required',
          'city' => 'required',
        ]);

        $type = 'nota';
        $marketing = auth()->user()->nama_lengkap;

        $nomor = $request['nomor'];

        $total = $request['payment'] + $request['paid'];

        $fileName = null;

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = 'nota_'.$nomor.'_'.$file->getClientOriginalName();
            $file->storeAs('public/nota', $fileName);
        }

        $data = [
          'file' => $fileName, 'type' => $type, 'nomor' => $request['nomor'], 'marketing' => $marketing,
          'tanggal' => $request['tanggal'], 'bulan' => $request['bulan'], 'tahun' => $request['tahun'],
          'customer' => $request['customer'], 'telepon' => $request['telepon'],
          'amount' => $request['amount'], 'payment' => $request['payment'], 'paid' => $request['paid'], 'total' => $total, 'street' => $request['street'],
          'district' => $request['district'], 'city' => $request['city'],
        ];

        ModelsNota::updateOrCreate(
            ['id' => $request->id],
            $data
        );

        return redirect()->route('laporan-nota.add')->with('success', 'Data nota berhasil ditambahkan.');
    }

    public function put(Request $request, $id)
    {
        $this->validate($request, [
          'file' => 'mimes:jpg,jpeg,png,gif|max:2048',
          'nomor' => 'required',
          'tanggal' => 'required',
          'bulan' => 'required',
          'tahun' => 'required',
          'amount' => 'required',
          'payment' => 'required',
          'paid' => 'required',
          'customer' => 'required',
          'telepon' => 'required',
          'street' => 'required',
          'district' => 'required',
          'city' => 'required',
        ]);

        $type = 'nota';
        $marketing = auth()->user()->nama_lengkap;

        $nomor = $request['nomor'];

        $total = $request['payment'] + $request['paid'];

        $file = $request->file('file');
        $fileName = 'nota_'.$nomor.'_'.$file->getClientOriginalName();
        $file->storeAs('public/nota', $fileName);

        $data = [
          'file' => $fileName, 'type' => $type, 'nomor' => $request['nomor'], 'marketing' => $marketing,
          'tanggal' => $request['tanggal'], 'bulan' => $request['bulan'], 'tahun' => $request['tahun'],
          'customer' => $request['customer'], 'telepon' => $request['telepon'],
          'amount' => $request['amount'], 'payment' => $request['payment'], 'paid' => $request['paid'], 'total' => $total, 'street' => $request['street'],
          'district' => $request['district'], 'city' => $request['city'],
        ];

        ModelsNota::where('id', $id)->update($data);

        return redirect()->route('laporan-nota')->with('success', 'Data nota berhasil diubah.');
    }

    public function delete($id)
    {
        ModelsNota::find($id)->delete($id);

        return response()->json(['success' => 'Record deleted successfully!']);
    }

    public function download($fileName)
    {
        $filePath = str_replace('/', '\\', storage_path('app/public/nota/'.$fileName));

        return response()->download($filePath);
    }
}
