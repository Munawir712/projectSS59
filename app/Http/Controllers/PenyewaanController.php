<?php

namespace App\Http\Controllers;

use App\Models\Kosan;
use App\Models\Penyewa;
use App\Models\Penyewaan;
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
        $penyewaan = Penyewaan::with('penyewa', 'kosan')->latest()->get();
        $penyewaanJatuhTempo = Penyewaan::with('penyewa', 'kosan')->where('tanggal_selesai', '<', now())->where('status', '=', 'sedang_disewa')->orWhere('status', '=', 'jatuh_tempo')->get();
        return view("penyewaan.index", [
            'penyewaan' => $penyewaan,
            'penyewaanJatuhTempo' => $penyewaanJatuhTempo,
            // 'penyewaanJatuhTempo' => $penyewaanJatuhTempo,
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
            'status' => [
                'belum_dikonfirmasi',
                'dikonfimasi',
                'sedang_disewa',
                'selesai',
                'dibatalkan',
                'jatuh_tempo'
            ],
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
            'status' => 'string',
        ]);
        $kosan = Kosan::find($request->kosan);
        $penyewaan = new Penyewaan();
        $penyewaan->penyewa_id = $request->penyewa;
        $penyewaan->kosan_id = $kosan->id;
        $penyewaan->tanggal_mulai = $request->tanggal_mulai;
        $penyewaan->jumlah_orang = $request->jumlah_orang;

        $tanggal_keluar = date('Y-m-d', strtotime($request->tanggal_mulai . ' + ' . $request->durasi_sewa . ' months') - 1);

        $penyewaan->tanggal_selesai = $tanggal_keluar;
        $penyewaan->durasi_sewa = $request->durasi_sewa;
        $penyewaan->total = $request->durasi_sewa * $kosan->harga;
        $penyewaan->status = $request->status;
        $penyewaan->save();

        return redirect('penyewaan')->with("message", "Data penyewaan berhasil ditambah");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('penyewaan.show', [
            'penyewaan' => Penyewaan::with('kosan', 'penyewa')->find($id),
            'status' => [
                'belum_dikonfirmasi',
                'dikonfirmasi',
                'sedang_disewa',
                'selesai',
                'dibatalkan',
            ],
        ]);
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
            'status' => [
                'belum_dikonfirmasi',
                'dikonfirmasi',
                'sedang_disewa',
                'selesai',
                'dibatalkan',
                'jatuh_tempo',
            ],
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

        if ($data['durasi_sewa'] != $penyewaan->durasi_sewa || $data['tanggal_mulai'] != $penyewaan->tanggal_mulai) {
            $kosan = Kosan::find($data['kosan_id']);
            $data['tanggal_selesai'] = date('Y-m-d', strtotime($request->tanggal_mulai . ' + ' . $request->durasi_sewa . ' months') - 1);
            $data['total'] = $data['durasi_sewa'] * $kosan->harga;
        }

        $penyewaan->update($data);

        return redirect()->route('penyewaan.index')->with('message', 'Penyewaan Berhasil diedit');
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
        return redirect('penyewaan')->with("message", "Data penyewaan berhasil dihapus");
    }

    public function pengajuanPenyewaan()
    {
        $penyewaan = Penyewaan::with('kosan', 'penyewa')->where('status', '=', 'belum_dikonfirmasi')->latest()->get();
        return view('penyewaan.ajuan_sewa', ['penyewaan' => $penyewaan]);
    }

    public function changeStatus(Request $request, $id, $status)
    {
        $penyewaan = Penyewaan::findOrFail($id);

        $penyewaan->status = $status;
        $penyewaan->save();
        return redirect()->route('penyewaan.index')->with('message', 'Status penyewaan ' . $id . ' berhasil diubah ke => ' . $status);
    }
}
