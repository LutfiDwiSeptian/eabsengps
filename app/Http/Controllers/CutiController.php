<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class CutiController extends Controller
{
    public function index()
    {
        $cuti = DB::table('master_cuti')->orderBy('kode_cuti','asc')->get();
        return view ('cuti.index',compact('cuti'));
    }

    public function store(Request $request)
    {
        $kode_cuti = $request->kode_cuti;
        $nama_cuti = $request->nama_cuti;
        $jml_hari = $request->jml_hari;

        $cek_cuti = DB::table('master_cuti')->where('kode_cuti',$kode_cuti)->count();
        if($cek_cuti> 0){
            return Redirect::back()->with(['warning' => 'Data kode cuti sudah ada']);
        }

        try{
            DB::table('master_cuti')->insert([
                'kode_cuti' => $kode_cuti,
                'nama_cuti' => $nama_cuti,
                'jml_hari' => $jml_hari
            ]);
            return Redirect::back()->with(['success' => 'Data berhasil disimpan']);
        }catch(\Exception $e){
            return Redirect::back()->with(['error' => 'Data gagal disimpan'. $e->getMessage()]);
        }

    }

    public function edit(Request $request)
    {
        $kode_cuti = $request->kode_cuti;
        $cuti = DB::table('master_cuti')->where('kode_cuti', $kode_cuti)->first();
        return view('cuti.edit', compact('kode_cuti'));
    }

    public function update(Request $request,$kode_cuti)
    {
        $nama_cuti = $request->nama_cuti;
        $jml_hari = $request->jml_hari;

        try {
            DB::table('master_cuti')->where('kode_cuti',$kode_cuti)->update([
                'nama_cuti' => $nama_cuti,
                'jml_hari' => $jml_hari
            ]);
            return Redirect::back()->with(['success' => 'Data berhasil diubah']);
        }catch(\Exception $e){
            return Redirect::back()->with(['error' => 'Data gagal diubah'. $e->getMessage()]);
        }

    }

    public function delete($kode_cuti)
    {
        // Cek apakah kode_cuti ada di database
        $cuti = DB::table('master_cuti')->where('kode_cuti', $kode_cuti)->first();
        if (!$cuti) {
            return Redirect::back()->with(['error' => 'Data tidak ditemukan']);
        }

        try {
            DB::table('master_cuti')->where('kode_cuti', $kode_cuti)->delete();
            return Redirect::back()->with(['success' => 'Data berhasil dihapus']);
        } catch (\Exception $e) {
            return Redirect::back()->with(['error' => 'Data gagal dihapus: ' . $e->getMessage()]);
        }
    }

}