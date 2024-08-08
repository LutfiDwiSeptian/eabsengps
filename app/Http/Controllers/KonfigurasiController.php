<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class KonfigurasiController extends Controller
{
    public function lokasikantor()
    {
        $lok_kantor = DB::table('konfigurasi_lokasi')->where('id',0)->first();
        return view('konfigurasi.lokasikantor',compact('lok_kantor'));
    }

    public function updatelokasi(Request $request)
    {
        $lokasi_kantor = $request->input('lokasikantor');
        $radius = $request->input('radius');

        // Pastikan lokasi_kantor dan radius tidak null
        if (empty($lokasi_kantor) || empty($radius)) {
            return Redirect::back()->with(['error' => 'Lokasi kantor atau radius tidak boleh kosong']);
        }

        $update = DB::table('konfigurasi_lokasi')->where('id', 0)->update([
            'lokasi_kantor' => $lokasi_kantor,
            'radius' => $radius
        ]);

        if ($update) {
            return Redirect::back()->with(['success' => 'DATA BERHASIL DIUPDATE']);
        } else {
            return Redirect::back()->with(['error' => 'DATA GAGAL DIUPDATE']);
        }
    }
}