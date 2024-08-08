<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class izinabsenController extends Controller
{
    public function create()
    {
        return view ('izin.create');
    }

    public function store(Request $request) 
    {
        $nik = Auth::guard('karyawan')->user()->nik; 
        $tanggal_dari = $request->tgl_izin_dari;
        $tanggal_sampai = $request->tgl_izin_sampai;
        $keterangan = $request->keterangan;
        $status = "izin";

        $bulan = date("m",strtotime($tanggal_dari));
        $tahun = date("Y",strtotime($tanggal_dari));
        $thn = substr($tahun,2,2); 

        $lastizin = DB::table('pengajuan_izin')
        ->whereRaw('MONTH(tanggal)='.$bulan)
        ->whereRaw('YEAR(tanggal)='.$tahun)
        ->orderBy('kode_izin','desc')
        ->first();

        $lastkodeizin = $lastizin != null ? $lastizin->kode_izin : "";
        $formatkode = "IZ" . $bulan . $thn;
        $kodeizin = buatkode($lastkodeizin, $formatkode,4);

        //dd($kodeizin);

        $data = [
            'kode_izin' => $kodeizin,
            'nik' => $nik,
            'tanggal' =>$tanggal_dari,
            'tgl_izin_sampai' => $tanggal_sampai,
            'keterangan' => $keterangan,
            'status' => $status
        ];

        $simpan = DB::table('pengajuan_izin')->insert($data);
        if($simpan){
            return redirect('/presensi/izin')->with('success','Data Berhasil Tersimpan');
        } else {
            return redirect('/presensi/izin')->with('error','Data tidak tersimpan');
        }
    }

    public function edit($kode_izin)
    {
        $dataizin = DB::table('pengajuan_izin')->where('kode_izin', $kode_izin)->first();
        return view('izin.edit', compact('dataizin'));
    }

    public function update(Request $request, $kode_izin)
    {
        $tanggal_dari = $request->tgl_izin_dari;
        $tanggal_sampai = $request->tgl_izin_sampai;
        $keterangan = $request->keterangan;
        
        try {
            $data = [
                'tanggal' => $tanggal_dari,
                'tgl_izin_sampai' => $tanggal_sampai, // Corrected key name
                'keterangan' => $keterangan
            ];

            DB::table('pengajuan_izin')->where('kode_izin', $kode_izin)->update($data); // Added $data parameter
            return redirect('/presensi/izin')->with(['success' => 'Data berhasil disimpan']); // Changed Redirect to redirect
        } catch(\Exception $e){
            return redirect('/presensi/izin')->with(['error' => 'Data gagal disimpan']); // Changed Redirect to redirect
        }

    }
}