<?php

namespace App\Http\Controllers;

use App\Models\KamarKos;
use App\Models\Penyewaan;
use App\Models\User;
use Illuminate\Http\Request;

class PenyewaanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $penyewaan = Penyewaan::all();
        return view("penyewaan.index", [
            'penyewaan' => $penyewaan,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('penyewaan.create', [
            'penyewa' => User::where('roles', 'USER')->get(),
            'kamarkos' => KamarKos::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $kamarkos = KamarKos::find($request->kamarkos);
        $penyewaan = new Penyewaan();
        $penyewaan->user_id = $request->penyewa;
        $penyewaan->kamarkos_id = $request->kamarkos;
        $penyewaan->tanggal_mulai = $request->tanggal_mulai;
        $penyewaan->tanggal_selesai = $request->tanggal_selesai;
        $penyewaan->durasi_sewa = $request->durasi_sewa;
        $penyewaan->total = $request->durasi_sewa * $kamarkos->harga;
        $penyewaan->save();

        return redirect('penyewaan')->with("message", "Tambah Berhasil");
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
