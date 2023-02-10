<?php

namespace App\Http\Controllers;

use App\Models\KamarKos;
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
        return view('kamarkos.index',[
            "kamarkos" => KamarKos::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tipe_kamar = ["Biasa", "Menengah", "Lengkap"];
        return view('kamarkos.create', ['tipe_kamar' => $tipe_kamar]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $kamarkos = new KamarKos;
        $kamarkos->no_kamar = $request->no_kamar;
        $kamarkos->name = $request->name;
        $kamarkos->tipe = $request->tipe_kamar;
        $kamarkos->harga = $request->harga;
        $kamarkos->picturePath = "default.png";
        $kamarkos->save();

        return redirect('kamarkos')->with('message', 'Data Kamar kos ditambahkan');
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
        $tipe_kamar = ["Biasa", "Menengah", "Lengkap"];
        $kamarkos = KamarKos::find($id);
        return view('kamarkos.edit', [
            'kamarkos' => $kamarkos,
            'tipe_kamar'=> $tipe_kamar,
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
        $kamarkos = KamarKos::find($id);
        $kamarkos->no_kamar = $request->no_kamar;
        $kamarkos->name = $request->name;
        $kamarkos->tipe = $request->tipe_kamar;
        $kamarkos->harga = $request->harga;
        $kamarkos->picturePath = "default.png";
        $kamarkos->save();

        return redirect('kamarkos')->with('message', 'Data Kamar kos diubah');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        KamarKos::destroy($id);
        return redirect('kamarkos')->with('message', 'Data Kamar kos telah dihapus');
    }
}
