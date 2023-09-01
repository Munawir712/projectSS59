<?php

namespace App\Http\Controllers;

use App\Models\Kosan;
use App\Models\Penyewa;
use App\Models\Penyewaan;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // return view('home');
        return view('dashboard.index', [
            'kosan' => Kosan::all()->count(),
            'penyewa' => Penyewa::all()->count(),
            'penyewaanTempo' => Penyewaan::where('tanggal_selesai', '<', now())->where('status', '=', 'sedang_disewa')->orWhere('status', '=', 'jatuh_tempo')->count(),
            'penyewaan' => Penyewaan::all()->count(),
            'users' => User::all()->count(),
        ]);
    }
}
