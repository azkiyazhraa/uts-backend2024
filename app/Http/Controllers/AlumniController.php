<?php

namespace App\Http\Controllers;

use App\Models\Alumni;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AlumniController extends Controller
{
    public function index()
    {
        // menarik semua data pada tabel alumni
        $data = Alumni::all();

        // pengecekan jika data kosong
        if ($data->isEmpty()) {
            return response()->json([
                'message' => 'Data is empty',
            ], 200);
        } else { // jika data tidak kosong maka tampilkan semua data
            return response()->json([
                'message' => 'Get All Resources',
                'data' => $data,
            ], 200);
        }
    }

    public function store(Request $request)
    {
        // membuat validasi bahwa semua field harus diisikan
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'graduation_year' => 'required',
            'status' => 'required',
            'company_name' => 'required',
            'position' => 'required',
        ]);

        // pengecekan jika validasi gagal / field tidak diisikan
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Invalid data',
                'errors' => $validator->errors(),
            ], 422);
        }

        // menambahkan data kedalam database
        $alumni = Alumni::create($validator->validated());

        // mengembalikan response berhasil menambah data
        return response()->json([
            'message' => 'Resource added successfully',
            'data' => $alumni,
        ], 201);
    }


    public function show($id)
    {
        // mengambil data berdasarkan parameter id yang dikirim
        $data = Alumni::find($id);

        // pengecekan jika data kosong / tidak di temukan
        if (!$data) {
            return response()->json([
                'message' => 'Resource not found',
            ], 404);
        } else { // jika data tidak kosong maka tampilkan data berdasarkan parameter id yang dikirim
            return response()->json([
                'message' => 'Get Detail Resource',
                'data' => $data,
            ], 200);
        }
    }

    public function update(Request $request, $id)
    {
        // membuat validasi bahwa semua field harus diisikan
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'graduation_year' => 'required',
            'status' => 'required',
            'company_name' => 'required',
            'position' => 'required',
        ]);

        // pengecekan jika validasi gagal / field tidak diisikan
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Invalid data',
                'errors' => $validator->errors(),
            ], 422);
        }

        // mengambil data berdasarkan parameter id yang dikirim
        $alumni = Alumni::find($id);

        // pengecekan jika data tidak di temukan
        if (!$alumni) {
            return response()->json([
                'message' => 'Resource not found',
            ], 404);
        }

        // mengubah data pada database berdasarkan parameter id yang dikirim
        $alumni->update($validator->validated());

        // mengembalikan response berhasil mengubah data
        return response()->json([
            'message' => 'Resource updated successfully',
            'data' => $alumni,
        ], 200);
    }


    public function destroy($id)
    {
        // mengambil data berdasarkan parameter id yang dikirim
        $alumni = Alumni::find($id);

        // pengecekan jika data tidak di temukan
        if (!$alumni) {
            return response()->json([
                'message' => 'Resource not found',
            ], 404);
        }

        // menghapus data pada database berdasarkan parameter id yang dikirim
        $alumni->delete();

        // mengembalikan response berhasil menghapus data
        return response()->json([
            'message' => 'Resource is deleted successfully',
        ], 200);
    }

    public function search($name)
    {
        // mengambil data berdasarkan nama yang diinputkan dalam parameter
        $alumni = Alumni::where('name', 'like', '%' . $name . '%')->get();

        // pengecekan jika data tidak di temukan
        if (!$alumni) {
            return response()->json([
                'message' => 'Resource not found',
            ], 404);
        }

        // mengembalikan response berhasil mencari data berdasarkan nama yang diinputkan
        return response()->json([
            'message' => 'Get searched resource',
            'data' => $alumni,
        ], 200);
    }

    public function freshgraduate()
    {
        // menarik semua data pada tabel alumni dengan kondisi bahwa status fresh graduated
        $alumni = Alumni::where('status', 'graduated')->get();

        // pengecekan jika data kosong atau data tidak ditemukan
        if ($alumni->isEmpty()) {
            return response()->json([
                'message' => 'Resource not found',
            ], 404);
        }

        // menghitung ada berapa banyak jumlah data yang berdasarkan status fresh graduated dengan menggunakan function count
        $total = $alumni->count();

        // mengembalikan response berhasil menarik semua data pada tabel alumni dengan kondisi bahwa status fresh graduated
        return response()->json([
            'message' => 'Get fresh graduate resources',
            'total' => $total,
            'data' => $alumni,
        ], 200);
    }


    public function employed()
    {
        // menarik semua data pada tabel alumni dengan kondisi bahwa status employed
        $alumni = Alumni::where('status', 'employed')->get();

        // pengecekan jika data kosong
        if ($alumni->isEmpty()) {
            return response()->json([
                'message' => 'Resource not found',
            ], 404);
        }

        // menghitung ada berapa banyak jumlah data yang berdasarkan status employed dengan menggunakan function count
        $total = $alumni->count();

        // mengembalikan response berhasil menarik semua data pada tabel alumni dengan kondisi bahwa status employed
        return response()->json([
            'message' => 'Get employed resource',
            'total' => $total,
            'data' => $alumni,
        ], 200);
    }

    public function unemployed()
    {
        // menarik semua data pada tabel alumni dengan kondisi bahwa status unemployed
        $alumni = Alumni::where('status', 'unemployed')->get();

        // pengecekan jika data kosong
        if ($alumni->isEmpty()) {
            return response()->json([
                'message' => 'Resource not found',
            ], 404);
        }

        // menghitung ada berapa banyak jumlah data yang berdasarkan status unemployed dengan menggunakan function count
        $total = $alumni->count();

        // mengembalikan response berhasil menarik semua data pada tabel alumni dengan kondisi bahwa status unemployed
        return response()->json([
            'message' => 'Get unemployed resource',
            'total' => $total,
            'data' => $alumni,
        ], 200);
    }
}
