<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mahasiswa;
use Illuminate\Support\Facades\Validator;

class MahasiswaController extends Controller
{
    public function index()
    {
        $mahasiswas = Mahasiswa::paginate(10);

        return response()->json([
            'success' => true,
            'message' => 'List Data Mahasiswa',
            'data'    => $mahasiswas
        ], 200);
    }

    public function show($id)
    {
        $mahasiswa = Mahasiswa::find($id);

        if (!$mahasiswa) {
            return response()->json([
                'success' => false,
                'message' => 'Data Mahasiswa Tidak Ditemukan!',
                'data'    => null
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Detail Data Mahasiswa',
            'data'    => $mahasiswa
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama'     => 'required|string',
            'nim'      => 'required|unique:mahasiswas,nim',
            'jurusan'  => 'required|string',
            'fakultas' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $mahasiswa = Mahasiswa::create([
            'nama'     => $request->nama,
            'nim'      => $request->nim,
            'jurusan'  => $request->jurusan,
            'fakultas' => $request->fakultas,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data Mahasiswa Berhasil Ditambahkan!',
            'data'    => $mahasiswa
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $mahasiswa = Mahasiswa::find($id);

        if (!$mahasiswa) {
            return response()->json([
                'success' => false,
                'message' => 'Data Mahasiswa Tidak Ditemukan!',
                'data'    => null
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'nama'     => 'required|string',
            'nim'      => 'required|unique:mahasiswas,nim,'.$id,
            'jurusan'  => 'required|string',
            'fakultas' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $mahasiswa->update([
            'nama'     => $request->nama,
            'nim'      => $request->nim,
            'jurusan'  => $request->jurusan,
            'fakultas' => $request->fakultas,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data Mahasiswa Berhasil Diubah!',
            'data'    => $mahasiswa
        ], 200);
    }

    public function destroy($id)
    {
        $mahasiswa = Mahasiswa::find($id);

        if (!$mahasiswa) {
            return response()->json([
                'success' => false,
                'message' => 'Data Mahasiswa Tidak Ditemukan!',
                'data'    => null
            ], 404);
        }

        $mahasiswa->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data Mahasiswa Berhasil Dihapus!',
            'data'    => null
        ], 200);
    }
}