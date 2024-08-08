<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class IzinsakitController extends Controller
{
    public function create()
    {
        return view ('sakit.izinsakit');
    }

    public function store(Request $request) 
    {
        $nik = Auth::guard('karyawan')->user()->nik;
        $tanggal_dari = $request->tgl_izin_dari;
        $tanggal_sampai = $request->tgl_izin_sampai;
        $keterangan = $request->keterangan;
        $status = "sakit";
        
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
        
        if ($request->hasFile('sid')) {
            $sid = $kodeizin . "." . $request->file('sid')->getClientOriginalExtension();
        } else {
            $sid = "";
        }
        $data = [
            'kode_izin' => $kodeizin,
            'nik' => $nik,
            'tanggal' =>$tanggal_dari,
            'tgl_izin_sampai' => $tanggal_sampai,
            'keterangan' => $keterangan,
            'status' => $status,
            'SID' => $sid
        ];

        $simpan = DB::table('pengajuan_izin')->insert($data);
        if($simpan){
            if ($request->hasFile('sid')) {
                $sid = $kodeizin . "." . $request->file('sid')->getClientOriginalExtension();
                $folderPath = "public/uploads/sid/";
                $request->file('sid')->storeAs($folderPath, $sid);
              }   
            return redirect('/presensi/izin')->with('success','Data Berhasil Tersimpan');
        } else {
            return redirect('/presensi/izin')->with('error','Data tidak tersimpan');
        }
    }

    public function edit($kode_izin)
    {
        $datasakit = DB::table('pengajuan_izin')->where('kode_izin', $kode_izin)->first();
        return view ('sakit.edit', compact('datasakit'));
    }

    public function update($kode_izin,Request $request) 
    {
        $tanggal_dari = $request->tgl_izin_dari;
        $tanggal_sampai = $request->tgl_izin_sampai;
        $keterangan = $request->keterangan;
        
        
        if ($request->hasFile('sid')) {
            $sid = $kode_izin . "." . $request->file('sid')->getClientOriginalExtension();
        } else {
            $sid = "";
        }
        $data = [
            'kode_izin' => $kode_izin,
            'tanggal' =>$tanggal_dari,
            'tgl_izin_sampai' => $tanggal_sampai,
            'keterangan' => $keterangan,
            'SID' => $sid
        ];
        try {
            DB::table('pengajuan_izin')->where('kode_izin', $kode_izin)->update($data);
            if ($request->hasFile('sid')) {
                $sid = $kode_izin . "." . $request->file('sid')->getClientOriginalExtension();
                $folderPath = "public/uploads/sid/";
                $request->file('sid')->storeAs($folderPath, $sid);
              }  
              return redirect('/presensi/izin')->with('success','Data Berhasil Ter-update'); 
        } catch(\Exception $e){
             return redirect('/presensi/izin')->with('error','Data tidak ter-update');
        }
       
    }

}
