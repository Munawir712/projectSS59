<?php

namespace App\Http\Controllers;

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
        $penyewa = User::where('roles', 'USER')->get();
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
        $penyewa = new User;
        $penyewa->name = $request->name;
        $penyewa->email = $request->email;
        $penyewa->phoneNumber = $request->phoneNumber;
        $penyewa->jenis_kelamin = $request->jenis_kelamin;
        $penyewa->password = bcrypt("password");
        $penyewa->foto_ktp ="";
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
        return view('penyewa.edit', [
            'penyewa'=> User::find($id),
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
        $penyewa = User::find($id);
        $penyewa->name = $request->name;
        $penyewa->email = $request->email;
        $penyewa->phoneNumber = $request->phoneNumber;
        $penyewa->jenis_kelamin = $request->jenis_kelamin;
        $penyewa->password = bcrypt("password");
        $penyewa->foto_ktp ="";
        $penyewa->save();

        return redirect('penyewa')->with("message", "Data Berhasil diUbah");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // dd($id);
        User::destroy($id);
        return redirect('penyewa')->with("message", "Data penyea sudah dihapus");
    }
}
