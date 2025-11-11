<?php

namespace App\Http\Controllers;

use App\Models\Absen;
use App\Models\Peserta;
use Illuminate\Http\Request;

class AbsenController extends Controller
{
    public function index()
    {
        // Ambil 5 absensi terakhir
        $last5Absen = Absen::with('peserta')
            ->orderBy('tanggal_masuk', 'desc')
            ->limit(5)
            ->get();

        return view('absen.index', compact('last5Absen'));
    }

    public function check(Request $request)
    {
        $request->validate([
            'no_peserta' => 'required|string',
        ]);

        // Cari peserta berdasarkan No. Peserta
        $peserta = Peserta::where('no_peserta', $request->no_peserta)
            ->first();

        if (!$peserta) {
            return redirect()
                ->back()
                ->with('error_no_peserta', true)
                ->with('error_message', 'No. Peserta tidak ditemukan!');
        }

        // Cek apakah sudah pernah absen hari ini
        $today = now()->startOfDay();
        $todayAbsen = Absen::where('id_peserta', $peserta->id)
            ->whereDate('tanggal_masuk', $today)
            ->with('peserta')
            ->first();

        if ($todayAbsen) {
            return redirect()
                ->back()
                ->with('already_absen', true)
                ->with('absen_data', [
                    'nama' => $todayAbsen->peserta->nama_lengkap,
                    'email' => $todayAbsen->peserta->email ?? '-',
                    'jam_masuk' => $todayAbsen->tanggal_masuk->format('H:i:s'),
                    'tanggal' => $todayAbsen->tanggal_masuk->format('d/m/Y'),
                    'no_peserta' => $request->no_peserta
                ]);
        }

        // Simpan absen baru
        $newAbsen = Absen::create([
            'id_peserta' => $peserta->id,
            'tanggal_masuk' => now(),
            'nomor_tiket' => $request->no_peserta,  // Simpan No. Peserta sebagai nomor_tiket untuk referensi
        ]);

        // Load relasi
        $newAbsen->load('peserta');

        return redirect()
            ->back()
            ->with('success_absen', true)
            ->with('absen_data', [
                'nama' => $newAbsen->peserta->nama_lengkap,
                'email' => $newAbsen->peserta->email ?? '-',
                'jam_masuk' => $newAbsen->tanggal_masuk->format('H:i:s'),
                'tanggal' => $newAbsen->tanggal_masuk->format('d/m/Y'),
                'no_peserta' => $request->no_peserta
            ]);
    }
}
