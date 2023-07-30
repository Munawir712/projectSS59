<?php

namespace App\Http\Controllers;

use App\Models\KamarKos;
use App\Models\Kosan;
use Illuminate\Http\Request;

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
        return view('kamarkos.create', ['category' => $category]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $kosan = new kosan;
        $kosan->no_kamar = $request->no_kamar;
        $kosan->name = $request->name;
        $kosan->category = $request->category;
        $kosan->alamat = $request->alamat;
        $kosan->harga = $request->harga;
        $kosan->gender_category = $request->gender_category;
        $kosan->max_orang = $request->max_orang;
        $kosan->save();

        return redirect('kosan')->with('message', 'Data Kamar kos ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        $category = ["minimalis", "reguler", "premium"];
        $kosan = Kosan::find($id);
        return view('kamarkos.edit', [
            'kamarkos' => $kosan,
            'category' => $category,
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
        $kosan = Kosan::find($id);
        $kosan->no_kamar = $request->no_kamar;
        $kosan->name = $request->name;
        $kosan->category = $request->category;
        $kosan->gender_category = $request->gender_category;
        $kosan->harga = $request->harga;
        $kosan->max_orang = $request->max_orang;
        $kosan->save();

        return redirect('kosan')->with('message', 'Data Kamar kos diubah');
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
