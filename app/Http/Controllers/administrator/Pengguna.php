<?php

namespace App\Http\Controllers\administrator;

use App\DataTables\PenggunaDataTable;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class Pengguna extends Controller
{
    public function index(PenggunaDataTable $datatable)
    {
        return $datatable->render('content.administrator.pengguna.pengguna');
    }

    public function add()
    {
        return view('content.administrator.pengguna.pengguna-add');
    }

    public function update($id)
    {
        $data = User::get()->find($id);

        return view('content.administrator.pengguna.pengguna-update', compact('data'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
          'nama_lengkap' => 'required',
          'email' => 'required',
          'telepon' => 'required',
          'password' => 'required',
          'role' => 'required',
        ]);

        $role = $request['role'];

        $data = [
          'nama_lengkap' => $request['nama_lengkap'], 'email' => $request['email'],
          'telepon' => $request['telepon'], 'password' => $request['password'],
        ];

        $user = User::updateOrCreate(
            ['id' => $request->id],
            $data
        );

        $user->assignRole($role);

        return redirect()->route('pengguna.add')->with('success', 'Data pengguna berhasil ditambahkan.');
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

        User::where('id', $id)->update($data);

        return redirect()->route('jenis-mitra')->with('success', 'Data pengguna berhasil diubah.');
    }

    public function delete($id)
    {
        User::find($id)->delete($id);

        return response()->json(['success' => 'Record deleted successfully!']);
    }
}
