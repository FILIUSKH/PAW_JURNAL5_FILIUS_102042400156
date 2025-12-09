<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MataKuliah;
use App\Http\Resources\MatakuliahResource;
use Illuminate\Support\Facades\Validator;

class MatakuliahController extends Controller
{
    public function index()
    {
        $matakuliah = MataKuliah::latest()->paginate(5);

        return new MatakuliahResource(true, 'List Data Matakuliah', $matakuliah);
    }

    public function show($id)
    {
        $matakuliah = MataKuliah::find($id);

        if (!$matakuliah) {
            return response()->json([
                'success' => false,
                'message' => 'Data Matakuliah Tidak Ditemukan!',
            ], 404);
        }

        return new MatakuliahResource(true, 'Detail Data Matakuliah', $matakuliah);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'kode' => 'required|unique:mata_kuliahs',
            'sks'  => 'required|integer', // SKS harus angka
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $matakuliah = MataKuliah::create([
            'nama' => $request->nama,
            'kode' => $request->kode,
            'sks'  => $request->sks,
        ]);

        return new MatakuliahResource(true, 'Data Matakuliah Berhasil Ditambahkan!', $matakuliah);
    }

    public function update(Request $request, $id)
    {
        $matakuliah = MataKuliah::find($id);

        if (!$matakuliah) {
             return response()->json([
                'success' => false,
                'message' => 'Data Matakuliah Tidak Ditemukan!',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'kode' => 'required|unique:mata_kuliahs,kode,'.$id,
            'sks'  => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $matakuliah->update([
            'nama' => $request->nama,
            'kode' => $request->kode,
            'sks'  => $request->sks,
        ]);

        return new MatakuliahResource(true, 'Data Matakuliah Berhasil Diubah!', $matakuliah);
    }

    public function destroy($id)
    {
        $matakuliah = MataKuliah::find($id);

        if (!$matakuliah) {
             return response()->json([
                'success' => false,
                'message' => 'Data Matakuliah Tidak Ditemukan!',
            ], 404);
        }

        $matakuliah->delete();

        return new MatakuliahResource(true, 'Data Matakuliah Berhasil Dihapus!', null);
    }
}