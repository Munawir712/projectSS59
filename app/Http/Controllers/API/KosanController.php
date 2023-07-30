<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Facility;
use App\Models\Kosan;
use App\Models\KosanImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KosanController extends Controller
{

    public function all(Request $request)
    {
        $id = $request->input('id');
        $no_kamar = $request->input('no_kamar');
        $limit = $request->input('limit');
        $name = $request->input('name');
        $category = $request->input('category');
        $gender_category = $request->input('gender_category');
        $alamat = $request->input('alamat');

        if ($id) {
            $kosan = Kosan::find($id);
            if ($kosan) {
                return response()->json([
                    'message' => 'Data kos berhasil diambil',
                    'data' => $kosan->with('kosanImage', 'facilities')->get(),
                ]);
            } else {
                return response()->json([
                    'message' => 'Data kos tidak ditemukan',
                    'data' => null,
                ], 404);
            }
        }

        $kosan = Kosan::query();

        if ($no_kamar) {
            $kosan->where('no_kamar', 'like', '%' . $no_kamar . '%');
        }

        if ($name) {
            $kosan->where('name', 'like', '%' . $name . '%');
        }

        if ($alamat) {
            $kosan->where('alamat', 'like', '%' . $alamat . '%');
        }

        if ($category) {
            $kosan->where('category', 'like', '%' . $category . '%');
        }

        if ($gender_category) {
            $kosan->where('gender_category', 'like', '%' . $gender_category . '%');
        }

        $kosan->where('status', '=', 'tersedia');

        return response()->json([
            'message' => 'Data kosan berhasil diambil',
            'data' => $kosan->with('kosanImage', 'facilities')->paginate($limit),
        ], 200);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'no_kamar' => 'required|unique:kosans',
            'name' => 'required',
            'alamat' => 'required',
            'tipe' => 'required',
            'gender_category' => 'required',
            'harga' => 'required',
            'category' => 'required',
            'max_orang' => 'required|int',
            'images' => 'array',
            'facilities' => 'array',
            'status' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 400);
        }

        $kosan = new Kosan();
        $kosan->no_kamar = $request->no_kamar;
        $kosan->name = $request->name;
        $kosan->alamat = $request->alamat;
        $kosan->tipe = $request->tipe;
        $kosan->gender_category = $request->gender_category;
        $kosan->description = $request->description;
        $kosan->harga = $request->harga;
        $kosan->category = $request->category;
        $kosan->max_orang = $request->max_orang;
        $kosan->status = $request->status;

        $kosan->save();

        if ($request->facilities) {
            $facilities = Facility::whereIn('slug', $request->facilities)->get();

            foreach ($facilities as $facility) {
                $kosan->facilities()->attach($facility);
            }
        }

        // Menyimpan Gambar
        if ($request->hasFile('images')) {
            $files = $request->file('images');
            foreach ($files as $file) {
                $filename = time() . '-' . $file->getClientOriginalName();
                $path = $file->store('kosan', 'public');

                $kosanImage = new KosanImage();
                $kosanImage->kosan_id = $kosan->id;
                $kosanImage->filename = $filename;
                // $kosanImage->image_url = asset('storage/' . $path);
                $kosanImage->image_url = 'storage/' . $path;
                $kosanImage->save();
            }
        }

        return response()->json([
            'message' => 'Data kosan berhasil ditambahkan',
            'data' => $kosan,
        ], 200);
    }
}
