<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Penyewa;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use Illuminate\Support\Facades\Validator;

class PenyewaController extends Controller
{
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email|unique:penyewas|string',
            'phone_number' => 'required|numeric|digits_between:12,13',
            'jenis_kelamin' => 'required',
            'foto_ktp' => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return ResponseFormatter::error(['error' => $validator->errors()], 'Data tidak valid');
        }

        $penyewa = Penyewa::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'jenis_kelamin' => $request->jenis_kelamin,
        ]);

        if ($request->hasFile('foto_ktp')) {
            if ($request->file('foto_ktp')) {
                $file = $request->foto_ktp->store('penyewa', 'public');
                $penyewa->foto_ktp = 'storage/' . $file;
                $penyewa->update();
            }
        }
        return ResponseFormatter::success($penyewa, 'Data Penyewa berhasil ditambah');
    }

    public function all(Request $request)
    {
        if ($request->user()) {
            return response()->json([
                'message' => 'Data user berhasil diambil',
                'data' => Penyewa::paginate(10),
            ]);
        } else {
            return response()->json([
                'message' => 'Unauthorize',
            ], 500);
        }
    }

    public function fetch(Request $request)
    {
        $penyewa = Penyewa::with('user')->where('user_id', $request->user()->id)->first();
        if ($penyewa != null) {
            return ResponseFormatter::success(
                $penyewa,
                'Data penyewa berhasil diambil',
            );
        } else {
            return ResponseFormatter::error(null, 'Data penyewa tidak ditemukan');
        }
    }
}
