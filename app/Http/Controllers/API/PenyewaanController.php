<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Penyewaan;
use DateTime;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Helpers\ResponseFormatter;
use App\Models\Kosan;
use App\Models\Penyewa;

class PenyewaanController extends Controller
{
    public function all(Request $request)
    {
        try {
            $penyewa = Penyewa::where('user_id', $request->user()->id)->first();
            $penyewaan = Penyewaan::with(['penyewa', 'kosan.kosanImage', 'kosan.facilities'])->where('penyewa_id', $penyewa->id)->latest()->get();
            return ResponseFormatter::success($penyewaan, 'Data transaksi penyewaan berhasil diambil',);
        } catch (Exception $error) {
            return ResponseFormatter::error($error->getMessage(), 'Gagal Mengambil data transaksi');
        }
    }

    public function checkout(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'kosan_id' => 'required|exists:kosans,id',
                'durasi_sewa' => 'required|int',
                'tanggal_mulai' => 'required|date',
                'jumlah_orang' => 'required|int',
                'total' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Transaksi penyewaan gagal',
                    'errors' => $validator->errors()
                ], 422);
            }

            // check kosan masih tersedia atau tidak
            $kosan = Kosan::find((int)$request->kosan_id);
            if ($kosan->status != "tersedia") {
                return response()->json([
                    'message' => 'Kos tidak tersedia',
                    'errors' => $validator->errors()
                ], 404);
                // return ResponseFormatter::error(["errors" => 'Kosan tidak tersedia'], 'Transaksi penyewaan gagal karena kosan sudah tidak tersedia', 422);
            }

            // check penyewaan yg masih berlaku
            $cekPenyewaan = Penyewaan::latest()->where('penyewa_id', $request->user()->id)->first();
            $date_keluar = date('Y-m-d', strtotime($request->tanggal_mulai . ' + ' . $request->durasi_sewa . ' months'));
            if ($cekPenyewaan && $cekPenyewaan->status == 'sedang_disewa') {
                $alreadyHaveSewa = strtotime($request->tanggal_mulai) < strtotime($cekPenyewaan->tanggal_selesai);
                if ($alreadyHaveSewa) {
                    return response()->json([
                        'message' => 'Anda masih memiliki kos yg sedang disewa',
                        'errors' => $validator->errors()
                    ], 422);
                    // return ResponseFormatter::error(["errors" => 'masih memiliki kos yg disewa'], 'Masih memiliki kos yg lagi disewa');
                }
            }

            // $kosan = Kosan::find((int)$request->kosan_id);
            // $kosan->status = "disewa";
            // $kosan->save();

            $penyewa = Penyewa::where('user_id', $request->user()->id)->first();
            $penyewaan = Penyewaan::create([
                'penyewa_id' => $penyewa->id,
                'kosan_id' => $request->kosan_id,
                'tanggal_mulai' => $request->tanggal_mulai,
                'tanggal_selesai' => $date_keluar,
                'durasi_sewa' => $request->durasi_sewa,
                'jumlah_orang' => $request->jumlah_orang,
                'total' => $request->total,
            ]);
            return ResponseFormatter::success($penyewaan, 'Transaksi Penyewaan berhasil');
        } catch (Exception $e) {
            return ResponseFormatter::error($e->getMessage(), 'Transaksi Penyewaan gagal');
        }
    }

    public function cancelPenyewaan(Request $request)
    {
        $request->validate(['penyewaan_id' => 'required|int']);
        if ($request->user()) {
            $penyewaan = Penyewaan::find($request->penyewaan_id);
            if ($penyewaan->status == 'selesai' || $penyewaan->status == 'sedang_disewa' || $penyewaan->status == 'dikonfirmasi') {
                return response()->json(['message' => 'Penyewaan gagal dibatalkan', 400]);
            }

            $penyewaan->status = 'dibatalkan';
            $penyewaan->save();

            return response()->json(['message' => 'Penyewaan berhasil dibatalkan',]);
        } else {
            return response()->json([
                'message' => 'Unauthorize',
            ], 500);
        }
    }

    public function cekTagihanV($penyewaanId)
    {
        $penyewaan = Penyewaan::findOrFail($penyewaanId);

        // Periksa apakah penyewaan sudah dalam status tertentu yang memungkinkan untuk cek tagihan
        if ($penyewaan->status === 'sedang_disewa') {
            // Hitung total tagihan berdasarkan harga sewa per bulan dan durasi_sewa
            $hargaSewaPerBulan = $penyewaan->total /  $penyewaan->durasi_sewa;
            $totalTagihan = $hargaSewaPerBulan * $penyewaan->durasi_sewa;

            // Tentukan tanggal jatuh tempo berikutnya setelah tanggal_mulai sewa
            $tanggalJatuhTempo = date('Y-m-d', strtotime($penyewaan->tanggal_mulai . ' +1 month'));

            $tagihan = [];

            while ($tanggalJatuhTempo <= $penyewaan->tanggal_selesai) {
                // Jika tanggal_jatuh_tempo melewati tanggal_selesai, atur tanggal_jatuh_tempo menjadi tanggal_selesai
                if ($tanggalJatuhTempo > $penyewaan->tanggal_selesai) {
                    $tanggalJatuhTempo = $penyewaan->tanggal_selesai;
                }

                $tagihanBulan = [
                    'tanggal_jatuh_tempo' => $tanggalJatuhTempo,
                    'total_tagihan' => $hargaSewaPerBulan
                ];

                $tagihan[] = $tagihanBulan;

                // Tentukan tanggal jatuh tempo bulan berikutnya
                $tanggalJatuhTempo = date('Y-m-d', strtotime($tanggalJatuhTempo . ' +1 month'));
            }

            return response()->json(['tagihan' => $tagihan]);
        }

        return response()->json(['message' => 'Tidak dapat cek tagihan pada status penyewaan ini.']);
    }

    public function cekTagihan($penyewaanId)
    {
        $penyewaan = Penyewaan::findOrFail($penyewaanId);

        // Periksa apakah penyewaan sudah dalam status tertentu yang memungkinkan untuk cek tagihan
        if ($penyewaan->status === 'sedang_disewa') {
            // Hitung total tagihan berdasarkan harga sewa per bulan dan durasi_sewa
            $hargaSewaPerBulan = $penyewaan->total / $penyewaan->durasi_sewa;
            $totalTagihan = $hargaSewaPerBulan * $penyewaan->durasi_sewa;

            // Tentukan tanggal jatuh tempo berikutnya setelah tanggal_mulai sewa
            $tanggalJatuhTempo = date('Y-m-d', strtotime($penyewaan->tanggal_mulai));

            $tagihan = [];

            while ($tanggalJatuhTempo <= $penyewaan->tanggal_selesai) {
                // Jika tanggal_jatuh_tempo melewati tanggal_selesai, atur tanggal_jatuh_tempo menjadi tanggal_selesai
                if ($tanggalJatuhTempo > $penyewaan->tanggal_selesai) {
                    $tanggalJatuhTempo = $penyewaan->tanggal_selesai;
                }

                // Hitung jumlah hari untuk bulan ini
                $jumlahHari = $this->hitungJumlahHari($penyewaan->tanggal_mulai, $tanggalJatuhTempo);

                $tagihanBulan = [
                    'tanggal_jatuh_tempo' => $tanggalJatuhTempo,
                    'total_tagihan' => $hargaSewaPerBulan,
                    'jumlah_hari' => $jumlahHari
                ];

                $tagihan[] = $tagihanBulan;

                // Tentukan tanggal jatuh tempo bulan berikutnya
                $tanggalJatuhTempo = date('Y-m-d', strtotime($tanggalJatuhTempo . ' +1 month'));
            }

            return response()->json(['tagihan' => $tagihan]);
        }

        return response()->json(['message' => 'Tidak dapat cek tagihan pada status penyewaan ini.']);
    }

    // ... method bayarTagihan() seperti sebelumnya

    // Fungsi untuk menghitung jumlah hari antara dua tanggal
    private function hitungJumlahHari($tanggalMulai, $tanggalSelesai)
    {
        $mulai = strtotime($tanggalMulai);
        $selesai = strtotime($tanggalSelesai);
        $diff = $selesai - $mulai;
        return round($diff / (60 * 60 * 24)) + 1; // Jumlah hari termasuk tanggal_mulai dan tanggal_selesai
    }

    // public function cekTagihan($penyewaanId)
    // {
    //     $penyewaan = Penyewaan::findOrFail($penyewaanId);

    //     // Periksa apakah penyewaan sudah dalam status tertentu yang memungkinkan untuk cek tagihan
    //     if ($penyewaan->status === 'sedang_disewa') {
    //         // Hitung harga sewa per hari berdasarkan total dan durasi_sewa
    //         $hargaSewaPerBulan = $penyewaan->total / $penyewaan->durasi_sewa;

    //         // Tentukan tanggal jatuh tempo berdasarkan tanggal_mulai sewa
    //         $tanggalMulai = $penyewaan->tanggal_mulai;
    //         $tanggalJatuhTempo = date('Y-m-d', strtotime($tanggalMulai . ' +1 month'));

    //         $tagihan = [];

    //         while ($tanggalJatuhTempo <= $penyewaan->tanggal_selesai) {
    //             $tagihanBulan = [
    //                 'tanggal_jatuh_tempo' => $tanggalJatuhTempo,
    //                 'jumlah_hari' => 0,
    //                 'total_tagihan' => 0
    //             ];

    //             // Hitung jumlah hari dan total tagihan untuk bulan ini
    //             while ($tanggalMulai <= $penyewaan->tanggal_selesai && date('Y-m-d', strtotime($tanggalMulai)) == $tanggalJatuhTempo) {
    //                 $tagihanBulan['jumlah_hari']++;
    //                 $tagihanBulan['total_tagihan'] = $hargaSewaPerBulan;
    //                 $tanggalMulai = date('Y-m-d', strtotime($tanggalMulai . ' +1 day'));
    //             }

    //             $tagihan[] = $tagihanBulan;
    //             $tanggalJatuhTempo = date('Y-m-d', strtotime($tanggalJatuhTempo . ' +1 month'));
    //         }

    //         return response()->json(['tagihan' => $tagihan]);
    //     }

    //     return response()->json(['message' => 'Tidak dapat cek tagihan pada status penyewaan ini.']);
    // }

    // public function cekTagihan($penyewaanId)
    // {
    //     $penyewaan = Penyewaan::findOrFail($penyewaanId)->load('kosan');
    //     // dd($penyewaan->status == 'sedang_disewa');
    //     // Periksa apakah penyewaan sudah dalam status tertentu yang memungkinkan untuk cek tagihan
    //     if ($penyewaan->status == 'sedang_disewa') {
    //         // Hitung tagihan berdasarkan durasi sewa dan harga kosan per hari
    //         // Misalnya, anggap harga kosan per hari adalah 100.000
    //         $totalTagihan = $penyewaan->total / $penyewaan->durasi_sewa;

    //         // Periksa apakah penyewaan sudah melewati tanggal_selesai
    //         $tanggalSekarang = '2023-07-20';
    //         $tanggalSelesai = $penyewaan->tanggal_selesai;

    //         if ($tanggalSekarang <= $tanggalSelesai) {
    //             // Tentukan tanggal jatuh tempo berdasarkan tanggal_mulai sewa
    //             $tanggalMulai = $penyewaan->tanggal_mulai;
    //             $tanggalJatuhTempo = date('Y-m-d', strtotime($tanggalMulai . ' +1 month'));
    //             // dd($tanggalJatuhTempo);

    //             if ($tanggalSekarang >= $tanggalJatuhTempo) {
    //                 // Jika penyewaan sudah jatuh tempo, maka kirimkan data tagihan
    //                 return response()->json([
    //                     // 'penyewaan' => $penyewaan,
    //                     'tagihan' => $totalTagihan,
    //                     'tanggal_jatuh_tempo' => $tanggalJatuhTempo
    //                 ]);
    //             }
    //         } else {
    //             // Jika tanggal_selesai sudah tercapai, maka tandai penyewaan sebagai selesai
    //             $penyewaan->status = 'selesai';
    //             $penyewaan->save();

    //             return response()->json(['message' => 'Penyewaan telah selesai.']);
    //         }
    //     }

    //     return response()->json(['message' => 'Tidak dapat cek tagihan pada status penyewaan ini.']);
    // }
}
