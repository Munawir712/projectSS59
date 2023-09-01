<?php

namespace App\Http\Controllers;

use App\Models\Penyewa;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('users.index', [
            'users' => User::where('roles', '=', 'USER')->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->username;
        $user->username = $request->username;
        $user->password = $request->password;
        $user->phone_number = $request->phoneNumber;
        $user->jenis_kelamin = $request->jenis_kelamin;
        if ($request->hasFile('foto_ktp')) {
            $user->foto_ktp = 'storage/' . $request->file('foto_ktp')->store('user', 'public');
        }
        $user->save();

        return redirect('users')->with("message", "Tambah User Berhasil");
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
        return view('users.edit', ['user' => User::find($id)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $data = $request->all();
        if ($request->hasFile('foto_ktp')) {
            $data['foto_ktp'] = 'storage/' . $request->file('foto_ktp')->store('user', 'public');
        }
        $user->update($data);
        // $user = User::find($id);
        // $user->name = $request->name;
        // $user->email = $request->email;
        // $user->phone_number = $request->phoneNumber;
        // $user->jenis_kelamin = $request->jenis_kelamin;
        // if ($request->hasFile('foto_ktp')) {
        //     $user->foto_ktp = 'storage/' . $request->file('foto_ktp')->store('user', 'public');
        // }
        // $user->save();

        return redirect('users')->with("message", "Data Berhasil diUbah");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::destroy($id);
        Penyewa::where('user_id', $id)->delete();
        return redirect('users')->with("message", "Data User berhasil dihapus");
    }
}
