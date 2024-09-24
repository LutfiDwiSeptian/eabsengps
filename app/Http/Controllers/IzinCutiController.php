<?php

namespace App\Http\Controllers;

use App\Facades\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class IzinCutiController extends Controller
{
    public function create()
    {
        $mastercuti = DB::table('master_cuti')->orderBy('kode_cuti')->get();
        return view('izincuti.create',compact('mastercuti'));
    }

    public function store(Request $request)
    {
        $nik = Auth::guard('karyawan')->user()->nik;
        $tanggal_dari = $request->tgl_izin_dari;
        $tanggal_sampai = $request->tgl_izin_sampai;
        $kodeizin = $request->kodeizin; // Change $kodeizin to $kode_izin for consistency.
        $kode_cuti = $request->kode_cuti; // Check if the variable $kode_cuti is correctly assigned from the request.
        $keterangan = $request->keterangan;
        $status = "cuti";

        $bulan = date("m",strtotime($tanggal_dari));
        $tahun = date("Y",strtotime($tanggal_dari));
        $thn = substr($tahun,2,2);

        $lastizin = DB::table('pengajuan_izin')
        ->whereRaw('MONTH(tanggal)='.$bulan)
        ->whereRaw('YEAR(tanggal)='.$tahun)
        ->orderBy('kode_izin','desc')
        ->first();

        $lastkodeizin = $lastizin != null ? $lastizin->kode_izin : ""; // Check if $lastizin->kode_cuti should be $lastizin->kode_izin.
        $formatkode = "IZ" . $bulan . $thn;
        $kodeizin = buatkode($lastkodeizin, $formatkode,4);

        //dd($kodeizin);

        $data = [
            'kode_izin' => $kodeizin,
            'nik' => $nik,
            'tanggal' =>$tanggal_dari,
            'tgl_izin_sampai' => $tanggal_sampai,
            'keterangan' => $keterangan,
            'kode_cuti' =>$kode_cuti,
            'status' => $status
        ];

        $simpan = DB::table('pengajuan_izin')->insert($data);
        if($simpan){
            NotificationService::sendNotificationAbsenToAllUsers(
                'Izin Absen Baru',
                'Ada karyawan yang mengajukan izin absen baru',
                '/presensi/izinsakit'
            );

            return redirect('/presensi/izin')->with('success','Data Berhasil Tersimpan');
        } else {
            return redirect('/presensi/izin')->with('error','Data tidak tersimpan');
        }
    }

    public function edit($kode_izin)
    {
        $datacuti = DB::table('pengajuan_izin')->where('kode_izin', $kode_izin)->first();
        $mastercuti = DB::table('master_cuti')->orderBy('kode_cuti')->get();
        return view('izincuti.edit',compact('mastercuti','datacuti'));
    }

    public function update($kode_izin, Request $request)
    {
        $tanggal_dari = $request->tgl_izin_dari;
        $tanggal_sampai = $request->tgl_izin_sampai;
        $kodeizin = $request->kodeizin; // Change $kodeizin to $kode_izin for consistency.
        $kode_cuti = $request->kode_cuti; // Check if the variable $kode_cuti is correctly assigned from the request.
        $keterangan = $request->keterangan;

        try {
            $data = [
                'kode_izin' => $kodeizin,
                'tanggal' =>$tanggal_dari,
                'tgl_izin_sampai' => $tanggal_sampai,
                'keterangan' => $keterangan,
                'kode_cuti' =>$kode_cuti,
            ];
            DB::table('pengajuan_izin')->where('kode_izin',$kode_izin)->update($data);
            return redirect('/presensi/izin')->with('success','Data Berhasil Ter-update');
        } catch (\Exception $e){
            return redirect('/presensi/izin')->with('error','Data tidak ter-update');
        }
    }
}
