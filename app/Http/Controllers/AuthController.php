<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        // membuat validasi bahwa semua field harus diisikan
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
        ]);

        // pengecekan jika validasi gagal / field tidak diisikan
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Invalid data',
                'errors' => $validator->errors(),
            ], 422);
        }

        // menambahkan data user kedalam database
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // menenciptakan password dengan function Hash::make
        ]);

        // mengembalikan response berhasil menambah data
        return response()->json([
            'message' => 'User created successfully',
        ], 201);
    }

    public function login(Request $request)
    {
        // membuat validasi bahwa semua field harus diisikan
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // pengecekan jika validasi gagal / field tidak diisikan
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Invalid data',
                'errors' => $validator->errors(),
            ], 422);
        }

        // mencoba login menggunakan email dan password
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user(); // mendapatkan user yang berhasil login

            // jika login berhasil, membuat token autentikasi
            $token = $user->createToken('authToken')->plainTextToken;

            return response()->json([
                'message' => 'Logged in successfully',
                'token' => $token,
            ]);
        }

        // jika login gagal
        return response()->json([
            'message' => 'Invalid credentials',
        ], 401);
    }
}
