<?php

namespace App\Http\Controllers;

use App\Models\karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $hariini = date("Y-m-d");
        $bulanini = date("m") * 1;
        $tahunini = date("Y");
        $inihari = date("N"); // Menggunakan "N" untuk mendapatkan hari dalam format numerik
        $tanggalini = date("d");
        $nik = Auth::guard('karyawan')->user()->nik;
        $presensihariini = DB::table('presensi')->where('nik',$nik)->where('tgl_presensi',$hariini)->first();
        $historibulanini = DB::table('presensi')->whereRaw('MONTH(tgl_presensi)="' .$bulanini.'"')
        ->where('nik', $nik)
        ->whereRaw('YEAR(tgl_presensi)="'.$tahunini.'"')
        ->orderByDesc('tgl_presensi')
        ->get();
        $rekapabsen = DB::table('presensi')
        ->selectRaw('COUNT(nik) as jmlhadir, SUM(IF(jam_in > "08:30",1,0)) as jmlterlambat')
        ->where('nik', $nik)
        ->whereRaw('MONTH(tgl_presensi)="'.$bulanini.'"')
        ->whereRaw('YEAR(tgl_presensi)="'.$tahunini.'"')
        ->first();

        $leaderboard = DB::table('presensi')
        ->join('karyawan', 'presensi.nik', '=', 'karyawan.nik')
        ->orderBy('jam_in')
        ->where('tgl_presensi', $hariini)
        ->get();
        $namabulan = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        $namahari = ["","Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu", "Minggu"];

        $rekapizin = DB::table('pengajuan_izin')
        ->selectRaw('SUM(IF(status="izin",1,0)) as jmlizin, SUM(IF(status="sakit",1,0)) as jmlsakit')
        ->where('nik', $nik)
        ->whereRaw('MONTH(tanggal)="'.$bulanini.'"')
        ->whereRaw('YEAR(tanggal)="'.$tahunini.'"')
        ->where('statues_approved', 1)
        ->first();
        return view('dashboard.dashboard', compact('presensihariini','historibulanini','namabulan','bulanini','tahunini','inihari','namahari','tanggalini','rekapabsen','leaderboard'
        ,'rekapizin'));
    }
    
    public function dashboardadmin()
    
    {
        $karyawan = DB::table('karyawan')->count();

        $hariini = date("Y-m-d");
        $rekapabsen = DB::table('presensi')
        ->selectRaw('COUNT(nik) as jmlhadir, SUM(IF(jam_in > "08:30",1,0)) as jmlterlambat')
        ->where('tgl_presensi',$hariini)
        ->first();

        $rekapizin = DB::table('pengajuan_izin')
        ->selectRaw('SUM(IF(status="izin",1,0)) as jmlizin, SUM(IF(status="sakit",1,0)) as jmlsakit')
        ->where('tanggal',$hariini)
        ->where('statues_approved', 1)
        ->first();

        return view('dashboard.dashboardadmin', compact('rekapabsen','rekapizin','karyawan'));
    }
}
