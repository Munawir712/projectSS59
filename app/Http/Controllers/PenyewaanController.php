<?php

namespace App\Http\Controllers;

use App\Models\KamarKos;
use App\Models\Kosan;
use App\Models\Penyewa;
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
        $penyewaan = Penyewaan::with('penyewa', 'kosan')->get();
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
            'penyewa' => Penyewa::all(),
            'kosan' => Kosan::all(),
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
        $request->validate([
            'penyewa' => 'required|int',
            'kosan' => 'required|int',
            'tanggal_mulai' => 'required',
            'jumlah_orang' => 'required|int',
            'durasi_sewa' => 'required|int',
        ]);
        $kosan = Kosan::find($request->kosan);
        $penyewaan = new Penyewaan();
        $penyewaan->penyewa_id = $request->penyewa;
        $penyewaan->kosan_id = $kosan->id;
        $penyewaan->tanggal_mulai = $request->tanggal_mulai;
        $penyewaan->jumlah_orang = $request->jumlah_orang;

        $tanggal_keluar = date('Y-m-d', strtotime($request->tanggal_mulai . ' + ' . $request->durasi_sewa . ' months'));

        $penyewaan->tanggal_selesai = $tanggal_keluar;
        $penyewaan->durasi_sewa = $request->durasi_sewa;
        $penyewaan->total = $request->durasi_sewa * $kosan->harga;
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
        return view('penyewaan.edit', [
            'penyewa' => Penyewa::all(),
            'kosan' => Kosan::all(),
            "penyewaan" => Penyewaan::find($id),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Penyewaan $penyewaan)
    {
        $data = $request->all();

        if ($data['durasi_sewa'] != $penyewaan->durasi_sewa) {
            $kosan = Kosan::find($request->kosan);
            $data['tanggal_selesai'] = date('Y-m-d', strtotime($request->tanggal_mulai . ' + ' . $request->durasi_sewa . ' months'));
            $data['total'] = $data['durasi_sewa'] * $kosan->harga;
        }

        $penyewaan->update($data);

        return redirect()->route('penyewaan.index')->with('alert', 'Penyewaan Berhasil diedit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Penyewaan::destroy($id);
        return redirect('penyewaan')->with("message", "Data penyewaan sudah dihapus");
    }
}
