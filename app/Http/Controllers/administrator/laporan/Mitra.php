<?php

namespace App\Http\Controllers\administrator\laporan;

use App\DataTables\MitraDataTable;
use App\Http\Controllers\Controller;
use App\Models\JenisMitra;
use App\Models\Mitra as ModelsMitra;
use Illuminate\Http\Request;

class Mitra extends Controller
{
    public function index(MitraDataTable $datatable)
    {
        $tahun = ModelsMitra::distinct()->pluck('tahun');

        $month = request('bulan');
        $year = request('tahun');

        return $datatable->with(compact('month', 'year'))->render('content.administrator.laporan.mitra.mitra', compact('tahun'));
    }

    public function add()
    {
        $listjenismitra = JenisMitra::get();

        return view('content.administrator.laporan.mitra.mitra-add', compact('listjenismitra'));
    }

    public function update($id)
    {
        $data = ModelsMitra::get()->find($id);

        return view('content.administrator.laporan.mitra.mitra-update', compact('data'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
          'type' => 'required',
          'tanggal' => 'required',
          'bulan' => 'required',
          'tahun' => 'required',
          'mitra' => 'required',
          'telepon' => 'required',
          'alamat' => 'required',
        ]);

        $marketing = auth()->user()->nama_lengkap;

        $data = [
          'type' => $request['type'], 'marketing' => $marketing, 'tanggal' => $request['tanggal'],
          'bulan' => $request['bulan'], 'tahun' => $request['tahun'], 'mitra' => $request['mitra'],
          'telepon' => $request['telepon'], 'alamat' => $request['alamat'],
        ];

        ModelsMitra::updateOrCreate(
            ['id' => $request->id],
            $data
        );

        return redirect()->route('laporan-mitra.add')->with('success', 'Data mitra berhasil ditambahkan.');
    }

    public function put(Request $request, $id)
    {
        $this->validate($request, [
          'type' => 'required',
          'tanggal' => 'required',
          'bulan' => 'required',
          'tahun' => 'required',
          'mitra' => 'required',
          'telepon' => 'required',
          'alamat' => 'required',
        ]);

        $marketing = auth()->user()->nama_lengkap;

        $data = [
          'type' => $request['type'], 'marketing' => $marketing, 'tanggal' => $request['tanggal'],
          'bulan' => $request['bulan'], 'tahun' => $request['tahun'], 'mitra' => $request['mitra'],
          'telepon' => $request['telepon'], 'alamat' => $request['alamat'],
        ];

        ModelsMitra::where('id', $id)->update($data);

        return redirect()->route('laporan-mitra')->with('success', 'Data mitra berhasil diubah.');
    }

    public function delete($id)
    {
        ModelsMitra::find($id)->delete($id);

        return response()->json(['success' => 'Record deleted successfully!']);
    }
}
