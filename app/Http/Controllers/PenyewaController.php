<?php

namespace App\Http\Controllers;

use App\Models\Penyewa;
use App\Models\User;
use Illuminate\Http\Request;

class PenyewaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $penyewa = Penyewa::all();
        return view("penyewa.index", ['penyewa' => $penyewa]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("penyewa.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $penyewa = new Penyewa();
        $penyewa->name = $request->name;
        $penyewa->email = $request->username . "@gmail.com";
        $penyewa->phone_number = $request->phoneNumber;
        $penyewa->jenis_kelamin = $request->jenis_kelamin;
        if ($request->hasFile('foto_ktp')) {
            $penyewa->foto_ktp = 'storage/' . $request->file('foto_ktp')->store('penyewa', 'public');
        }
        $penyewa->save();

        return redirect('penyewa')->with("message", "Tambah Berhasil");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('penyewa.show', ['penyewa' => Penyewa::find($id)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('penyewa.edit', [
            'penyewa' => Penyewa::find($id),
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
        // dd("Ayook");
        $penyewa = Penyewa::find($id);
        $penyewa->name = $request->name;
        $penyewa->email = $request->email;
        $penyewa->phone_number = $request->phoneNumber;
        $penyewa->jenis_kelamin = $request->jenis_kelamin;
        if ($request->hasFile('foto_ktp')) {
            $penyewa->foto_ktp = 'storage/' . $request->file('foto_ktp')->store('penyewa', 'public');
        }
        $penyewa->save();

        return redirect('penyewa')->with("message", "Data Berhasil diUbah");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Penyewa $penyewa)
    {
        $penyewa->delete();
        User::where('id', $penyewa->user_id)->delete();
        return redirect('penyewa')->with("message", "Data penyewa sudah dihapus");
    }
}
