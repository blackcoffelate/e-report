<?php

namespace App\Http\Controllers\administrator\laporan;

use App\DataTables\FollowupDataTable;
use App\Http\Controllers\Controller;
use App\Models\FollowUp as ModelsFollowUp;
use Illuminate\Http\Request;

class Followup extends Controller
{
    public function index(FollowupDataTable $datatable)
    {
        $tahun = ModelsFollowUp::distinct()->pluck('tahun');

        $month = request('bulan');
        $year = request('tahun');

        return $datatable->with(compact('month', 'year'))->render('content.administrator.laporan.followup.followup', compact('tahun'));
    }

    public function add()
    {
        return view('content.administrator.laporan.followup.followup-add');
    }

    public function update($id)
    {
        $data = ModelsFollowUp::get()->find($id);

        return view('content.administrator.laporan.followup.followup-update', compact('data'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
          'type' => 'required',
          'tanggal' => 'required',
          'bulan' => 'required',
          'tahun' => 'required',
          'customer' => 'required',
          'telepon' => 'required',
        ]);

        $marketing = auth()->user()->nama_lengkap;

        $data = [
          'type' => $request['type'], 'marketing' => $marketing, 'tanggal' => $request['tanggal'],
          'bulan' => $request['bulan'], 'tahun' => $request['tahun'], 'customer' => $request['customer'],
          'telepon' => $request['telepon'], 'keterangan' => $request['keterangan'],
        ];

        ModelsFollowUp::updateOrCreate(
            ['id' => $request->id],
            $data
        );

        return redirect()->route('laporan-followup.add')->with('success', 'Data follow up berhasil ditambahkan.');
    }

    public function put(Request $request, $id)
    {
        $this->validate($request, [
          'type' => 'required',
          'tanggal' => 'required',
          'bulan' => 'required',
          'tahun' => 'required',
          'customer' => 'required',
          'telepon' => 'required',
        ]);

        $marketing = auth()->user()->nama_lengkap;

        $data = [
          'type' => $request['type'], 'marketing' => $marketing, 'tanggal' => $request['tanggal'],
          'bulan' => $request['bulan'], 'tahun' => $request['tahun'], 'customer' => $request['customer'],
          'telepon' => $request['telepon'], 'keterangan' => $request['keterangan'],
        ];

        ModelsFollowUp::where('id', $id)->update($data);

        return redirect()->route('laporan-followup')->with('success', 'Data follow up berhasil diubah.');
    }

    public function delete($id)
    {
        ModelsFollowUp::find($id)->delete($id);

        return response()->json(['success' => 'Record deleted successfully!']);
    }
}
