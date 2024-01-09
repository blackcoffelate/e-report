<?php

namespace App\Http\Controllers\administrator;

use App\DataTables\JenisMitraDataTable;
use App\Http\Controllers\Controller;
use App\Models\JenisMitra as ModelsJenisMitra;
use Illuminate\Http\Request;

class JenisMitra extends Controller
{
    public function index(JenisMitraDataTable $datatable)
    {
        return $datatable->render('content.administrator.masterdata.jenis-mitra');
    }

    public function add()
    {
        return view('content.administrator.masterdata.jenis-mitra-add');
    }

    public function update($id)
    {
        $data = ModelsJenisMitra::get()->find($id);

        return view('content.administrator.masterdata.jenis-mitra-update', compact('data'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
          'jenis_mitra' => 'required',
        ]);

        $data = [
          'jenis_mitra' => $request['jenis_mitra'], 'keterangan' => $request['keterangan'],
        ];

        ModelsJenisMitra::updateOrCreate(
            ['id' => $request->id],
            $data
        );

        return redirect()->route('jenis-mitra.add')->with('success', 'Data jenis mitra berhasil diubah.');
    }

    public function put(Request $request, $id)
    {
        $this->validate($request, [
          'jenis_mitra' => 'required',
        ]);

        $data = [
            'jenis_mitra' => $request['jenis_mitra'],
            'keterangan' => $request['keterangan'],
        ];

        ModelsJenisMitra::where('id', $id)->update($data);

        return redirect()->route('jenis-mitra')->with('success', 'Data jenis mitra berhasil ditambahkan.');
    }

    public function delete($id)
    {
        ModelsJenisMitra::find($id)->delete($id);

        return response()->json(['success' => 'Record deleted successfully!']);
    }
}
