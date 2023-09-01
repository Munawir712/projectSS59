<?php

namespace App\Http\Controllers;

use App\Models\Facility;
use App\Models\KamarKos;
use App\Models\Kosan;
use App\Models\KosanImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KamarkosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('kamarkos.index', [
            "kamarkos" => Kosan::with(['facilities', 'kosanImage'])->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $tipe_kamar = ["Biasa", "Menengah", "Lengkap"];
        $category = ["minimalis", "reguler", "premium"];
        $facilities = Facility::all();
        return view('kamarkos.create', ['category' => $category, 'facilities' => $facilities]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'no_kamar' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'tipe' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'harga' => 'required|numeric',
            'gender_category' => 'required|string|max:255',
            'max_orang' => 'required|integer',
            'jumlah_kos' => 'required|integer',
        ]);

        $kosan = new kosan;
        $kosan->no_kamar = $request->no_kamar;
        $kosan->name = $request->name;
        $kosan->category = $request->category;
        $kosan->tipe = $request->tipe;
        $kosan->alamat = $request->alamat;
        $kosan->harga = $request->harga;
        $kosan->gender_category = $request->gender_category;
        $kosan->max_orang = $request->max_orang;
        $kosan->description = $request->description;
        $kosan->jumlah_kos = $request->jumlah_kos;
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
                $kosanImage->image_url = 'storage/' . $path;
                $kosanImage->save();
            }
        }

        return redirect('kosan')->with('message', 'Data Kamar kos berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // dd(Kosan::find($id));
        return view('kamarkos.show', ['kosan' => Kosan::find($id)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // $tipe_kamar = ["Biasa", "Menengah", "Lengkap"];
        $facilities = Facility::all();
        $category = ["minimalis", "reguler", "premium"];
        $kosan = Kosan::with('facilities')->find($id);
        return view('kamarkos.edit', [
            'kamarkos' => $kosan,
            'category' => $category,
            'facilities' => $facilities,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'no_kamar' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'tipe' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'harga' => 'required|numeric',
            'gender_category' => 'required|string',
            'max_orang' => 'required|integer',
            'jumlah_kos' => 'required|integer',
        ]);

        $kosan = Kosan::find($id);
        $data = $request->all();
        $kosan->update($data);

        if ($request->facilities) {
            $selectedFacilities = Facility::whereIn('slug', $request->facilities)->pluck('id')->toArray();

            $kosan->facilities()->sync($selectedFacilities);
        }

        // Menyimpan Gambar
        if ($request->hasFile('images')) {
            $files = $request->file('images');

            // Hapus gambar lama
            foreach ($kosan->kosanImage as $image) {
                $filePath = str_replace('storage/', '', $image->image_url);
                Storage::disk('public')->delete($filePath);
                $image->delete();
            }

            foreach ($files as $file) {
                $filename = time() . '-' . $file->getClientOriginalName();
                $path = $file->store('kosan', 'public');

                $kosanImage = new KosanImage();
                $kosanImage->kosan_id = $kosan->id;
                $kosanImage->filename = $filename;
                $kosanImage->image_url = 'storage/' . $path;
                $kosanImage->save();
            }
        }

        return redirect('kosan')->with('message', 'Data Kamar kos berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Kosan::destroy($id);
        return redirect('kosan')->with('message', 'Data Kamar kos telah dihapus');
    }
}
